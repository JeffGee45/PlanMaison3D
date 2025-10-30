<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        // Récupérer le panier
        $cart = $this->cartService->getCart();
        
        // Ajouter des logs de débogage
        Log::info('Contenu du panier:', ['cart' => $cart->toArray()]);
        Log::info('Articles du panier:', ['items' => $cart->items->toArray()]);
        
        // Vérifier si les articles sont chargés
        if ($cart->items->isNotEmpty()) {
            Log::info('Premier article du panier:', ['item' => $cart->items->first()->toArray()]);
            Log::info('Relation housePlan du premier article:', ['housePlan' => $cart->items->first()->housePlan ? $cart->items->first()->housePlan->toArray() : 'null']);
        } else {
            Log::info('Le panier est vide');
        }
        
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
        try {
            $request->validate([
                'product_id' => 'required|exists:house_plans,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $productId = $request->input('product_id');
            $quantity = $request->input('quantity', 1);
            
            // Ajouter l'article au panier
            $this->cartService->addItem($productId, $quantity);
            
            // Vérifier si l'utilisateur a demandé à passer à la caisse
            if ($request->has('checkout')) {
                return redirect()->route('checkout')->with('success', 'Produit ajouté au panier. Poursuivez vers la caisse.');
            }
            
            return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier avec succès !');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de l\'ajout au panier: ' . $e->getMessage());
        }
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

    /**
     * Remove an item from the cart.
     *
     * @param  int  $itemId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeItem($itemId)
    {
        $this->cartService->removeItem($itemId);
        return back()->with('success', 'L\'article a été retiré du panier');
    }
}
