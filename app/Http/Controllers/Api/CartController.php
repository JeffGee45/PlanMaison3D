<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Coupon;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->middleware('auth:api')->except(['index', 'addItem']);
        $this->cartService = $cartService;
    }

    /**
     * Get the current cart.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $cart = $this->cartService->getCart();
        return Response::json([
            'success' => true,
            'data' => new CartResource($cart),
            'item_count' => $this->cartService->getItemCount(),
            'total' => $this->cartService->getTotal(),
            'subtotal' => $this->cartService->getSubtotal(),
            'tax' => $this->cartService->getTax(),
        ]);
    }

    /**
     * Add an item to the cart.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function addItem(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'options' => 'sometimes|array',
        ]);

        if ($validator->fails()) {
            return Response::json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $cart = $this->cartService->addItem(
            $request->input('product_id'),
            $request->input('quantity', 1),
            $request->input('options', [])
        );

        return Response::json([
            'success' => true,
            'message' => 'Item added to cart',
            'data' => new CartResource($cart),
            'item_count' => $this->cartService->getItemCount(),
        ]);
    }

    /**
     * Update item quantity in the cart.
     *
     * @param Request $request
     * @param int $itemId
     * @return JsonResponse
     */
    public function updateItem(Request $request, int $itemId): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $cart = $this->cartService->updateItemQuantity(
                $itemId,
                $request->input('quantity')
            );

            return Response::json([
                'success' => true,
                'message' => 'Cart updated',
                'data' => new CartResource($cart),
                'item_count' => $this->cartService->getItemCount(),
            ]);
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Remove an item from the cart.
     *
     * @param int $itemId
     * @return JsonResponse
     */
    public function removeItem(int $itemId): JsonResponse
    {
        $cart = $this->cartService->removeItem($itemId);

        return Response::json([
            'success' => true,
            'message' => 'Item removed from cart',
            'data' => new CartResource($cart),
            'item_count' => $this->cartService->getItemCount(),
        ]);
    }

    /**
     * Clear the cart.
     *
     * @return JsonResponse
     */
    public function clear(): JsonResponse
    {
        $this->cartService->clear();

        return Response::json([
            'success' => true,
            'message' => 'Cart cleared',
            'item_count' => 0,
            'total' => 0,
            'subtotal' => 0,
            'tax' => 0,
        ]);
    }

    /**
     * Apply a coupon to the cart.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function applyCoupon(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string|max:50',
        ]);

        $coupon = Coupon::where('code', strtoupper($request->input('code')))
            ->where('is_active', true)
            ->first();

        if (!$coupon || !$coupon->isValid()) {
            return Response::json([
                'success' => false,
                'message' => 'Code promo invalide ou expiré',
            ], 422);
        }

        $subtotal = $this->cartService->getSubtotal();

        if ($coupon->min_cart_amount && $subtotal < $coupon->min_cart_amount) {
            return Response::json([
                'success' => false,
                'message' => sprintf('Le montant minimum pour ce code promo est de %s €', number_format($coupon->min_cart_amount, 2, ',', ' ')),
            ], 422);
        }

        // Apply coupon to cart
        $this->cartService->applyCoupon($coupon);
        $cart = $this->cartService->getCart();

        return Response::json([
            'success' => true,
            'message' => 'Code promo appliqué avec succès',
            'data' => new CartResource($cart)
        ]);
    }

    /**
     * Remove the coupon from the cart.
     *
     * @return JsonResponse
     */
    public function removeCoupon(): JsonResponse
    {
        $this->cartService->removeCoupon();
        $cart = $this->cartService->getCart();

        return Response::json([
            'success' => true,
            'message' => 'Code promo retiré',
            'data' => new CartResource($cart)
        ]);
    }

    /**
     * Get the cart item count.
     *
     * @return JsonResponse
     */
    public function count(): JsonResponse
    {
        return Response::json([
            'success' => true,
            'count' => $this->cartService->getItemCount(),
        ]);
    }
}
