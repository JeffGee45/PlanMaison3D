<?php

namespace App\Services;

use App\Models\Products;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;

class CartService
{
    protected $cart;
    protected Collection $items;
    protected $coupon = null;

    public function __construct()
    {
        $this->items = collect();
        $this->initializeCart();
    }

    protected function initializeCart()
    {
        $user = Auth::user();
        $sessionId = Session::getId();
        
        if ($user) {
            // Utiliser le panier de l'utilisateur connecté
            $this->cart = Cart::firstOrCreate(
                ['user_id' => $user->id, 'status' => 'active'],
                ['session_id' => $sessionId]
            );
            
            // Fusionner avec le panier de session s'il existe
            if ($sessionId !== $this->cart->session_id) {
                $this->mergeCarts($this->cart, $sessionId);
            }
        } else {
            // Utiliser le panier de session pour les invités
            $this->cart = Cart::firstOrCreate(
                ['session_id' => $sessionId, 'user_id' => null, 'status' => 'active'],
                []
            );
        }
        
        // Charger les articles du panier
        $this->items = $this->cart->items()->with('product')->get()->keyBy('product_id');
        
        // Charger le coupon s'il existe
        if ($this->cart->coupon_code) {
            $this->coupon = Coupon::where('code', $this->cart->coupon_code)->first();
        }
        
        $this->calculateTotals();
    }
    
    /**
     * Get the current cart.
     *
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart->load('items.product');
    }
    
    /**
     * Get cart item count.
     *
     * @return int
     */
    public function getItemCount(): int
    {
        return $this->items->sum('quantity');
    }
    
    /**
     * Get cart subtotal.
     *
     * @return float
     */
    public function getSubtotal()
    {
        return $this->cart->subtotal;
    }
    
    /**
     * Get cart tax amount.
     *
     * @return float
     */
    public function getTax()
    {
        return $this->cart->tax;
    }
    
    /**
     * Get cart total.
     *
     * @return float
     */
    public function getTotal()
    {
        return $this->cart->total;
    }
    
    /**
     * Add an item to the cart.
     *
     * @param int $productId
     * @param int $quantity
     * @param array $options
     * @return Cart
     */
    public function addItem(int $productId, int $quantity = 1, array $options = [])
    {
        $product = Products::findOrFail($productId);
        
        // Vérifier si le produit est déjà dans le panier
        if ($this->items->has($productId)) {
            // Mettre à jour la quantité si le produit existe déjà
            $cartItem = $this->items[$productId];
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Créer un nouvel élément de panier
            $cartItem = new CartItem([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
                'options' => $options,
            ]);
            
            $this->cart->items()->save($cartItem);
            $this->items->put($productId, $cartItem);
        }
        
        $this->calculateTotals();
        return $this->cart->load('items.product');
    }
    
    /**
     * Update cart item quantity.
     *
     * @param int $itemId
     * @param int $quantity
     * @return Cart
     */
    public function updateItemQuantity(int $itemId, int $quantity)
    {
        $cart = $this->getCart();
        $item = $cart->items->firstWhere('id', $itemId);
        
        if (!$item) {
            throw new \Exception('Item not found in cart');
        }
        
        $item->updateQuantity($quantity);
        
        return $cart->load('items.product');
    }
    
    /**
     * Remove an item from the cart.
     *
     * @param int $itemId
     * @return Cart
     */
    public function removeItem(int $itemId)
    {
        $cart = $this->getCart();
        $item = $cart->items->firstWhere('id', $itemId);
        
        if ($item) {
            $item->delete();
            $cart->calculateTotals();
        }
        
        return $cart->load('items.product');
    }
    
    /**
     * Clear the cart.
     *
     * @return Cart
     */
    public function clear()
    {
        $cart = $this->getCart();
        $cart->items()->delete();
        $cart->update([
            'subtotal' => 0,
            'tax' => 0,
            'total' => 0
        ]);
        
        return $cart->load('items.product');
    }
    
    /**
     * Apply a coupon to the cart.
     *
     * @param Coupon $coupon
     * @return void
     */
    public function applyCoupon(Coupon $coupon)
    {
        $this->coupon = $coupon;
        $this->cart->update([
            'coupon_code' => $coupon->code
        ]);
        
        // Recalculate totals with the new coupon
        $this->calculateTotals();
        
        // Save the coupon ID in the session for guests
        if (!Auth::check()) {
            session(['applied_coupon_id' => $coupon->id]);
        }
    }
    
    /**
     * Remove the current coupon from the cart.
     *
     * @return void
     */
    public function removeCoupon()
    {
        $this->coupon = null;
        $this->cart->update([
            'coupon_code' => null,
            'discount' => 0
        ]);
        
        // Recalculate totals without the coupon
        $this->calculateTotals();
        
        // Remove the coupon from the session for guests
        if (!Auth::check()) {
            session()->forget('applied_coupon_id');
        }
    }
    
    /**
     * Get the current applied coupon.
     *
     * @return Coupon|null
     */
    public function getCoupon()
    {
        return $this->coupon;
    }
    
    /**
     * Calculate cart totals including tax and discounts.
     *
     * @return void
     */
    protected function calculateTotals()
    {
        $subtotal = $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        
        $taxRate = 0.2; // 20% de TVA
        $tax = $subtotal * $taxRate;
        $total = $subtotal + $tax;
        $discount = 0;
        
        // Appliquer la réduction du coupon si disponible
        if ($this->coupon && $this->coupon->isValid()) {
            $discount = $this->coupon->calculateDiscount($subtotal);
            $total = max(0, $total - $discount);
        }
        
        $this->cart->update([
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,
        ]);
    }
    
    /**
     * Get the cart summary.
     *
     * @return array
     */
    public function getSummary(): array
    {
        $this->calculateTotals(); // Ensure totals are up-to-date
        $cartData = $this->getCart();

        return [
            'item_count' => $cartData->items->sum('quantity'),
            'subtotal' => $cartData->subtotal,
            'discount' => $cartData->discount ?? 0,
            'tax' => $cartData->tax,
            'total' => $cartData->total,
            'coupon' => $this->coupon ? [
                'code' => $this->coupon->code,
                'value' => $this->coupon->value,
                'type' => $this->coupon->type,
                'discount_amount' => $this->cart->discount ?? 0,
            ] : null,
        ];
    }

    /**
     * Merge session cart with user cart upon login.
     *
     * @param Cart $userCart
     * @param string $sessionId
     * @return void
     */
    protected function mergeCarts(Cart $userCart, string $sessionId): void
    {
        $sessionCart = Cart::where('session_id', $sessionId)
            ->whereNull('user_id')
            ->where('id', '!=', $userCart->id)
            ->with('items')
            ->first();

        if ($sessionCart && $sessionCart->items->isNotEmpty()) {
            $userCartItems = $userCart->items->keyBy('product_id');

            foreach ($sessionCart->items as $sessionItem) {
                if (isset($userCartItems[$sessionItem->product_id])) {
                    // Product exists, update quantity
                    $userCartItems[$sessionItem->product_id]->increment('quantity', $sessionItem->quantity);
                } else {
                    // Product doesn't exist, move it to the user's cart
                    $sessionItem->cart_id = $userCart->id;
                    $sessionItem->save();
                }
            }

            // Safely delete the old session cart
            $sessionCart->items()->delete();
            $sessionCart->delete();
        }

        // Ensure the user cart has the current session ID
        $userCart->update(['session_id' => $sessionId]);

        // Reload items and recalculate totals
        $this->initializeCart();
    }
}
