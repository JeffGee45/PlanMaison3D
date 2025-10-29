<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display the cart page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cart = $this->cartService->getCart();
        $summary = $this->cartService->getSummary();

        // Assurez-vous que la vue 'cart.index' existe et qu'elle inclut la vue partielle 'cart._cart'
        return view('cart.index', [
            'cartItems' => $cart->items,
            'summary' => $summary
        ]);
    }

    /**
     * Add an item to the cart and redirect back.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addItem(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $this->cartService->addItem(
            $request->input('product_id'),
            $request->input('quantity', 1)
        );

        return back()->with('success', 'Produit ajouté au panier avec succès');
    }

    /**
     * Clear the cart and redirect back.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clear()
    {
        $this->cartService->clear();
        return back()->with('success', 'Votre panier a été vidé');
    }
}
