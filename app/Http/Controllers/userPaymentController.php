<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

use App\Helpers\CinetPay;
use App\Models\PaymentGateway;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Products;
use Illuminate\Http\Request;

class userPaymentController extends Controller
{
    public function initPayment($id)
    {
        $articleInfo = Products::findOrFail($id);
        
        // Créer une nouvelle commande
        $order = new Order();
        $order->user_id = Auth::id();
        $order->total_amount = $articleInfo->price;
        $order->status = 'pending';
        $order->save();
        
        // Ajouter l'article à la commande
        $orderItem = new OrderItem();
        $orderItem->order_id = $order->id;
        $orderItem->item_type = get_class($articleInfo);
        $orderItem->item_id = $articleInfo->id;
        $orderItem->name = $articleInfo->name;
        $orderItem->quantity = 1;
        $orderItem->price = $articleInfo->price;
        $orderItem->total = $articleInfo->price;
        $orderItem->save();
        
        // Préparer les données pour le paiement
        $notify_url = route('payment.notify');
        $return_url = route('payment.success', ['order' => $order->id]);
        
        $paymentData = [
            "transaction_id" => 'CMD-' . $order->id . '-' . time(),
            "amount" => $articleInfo->price,
            "currency" => 'XOF',
            "customer_surname" => Auth::user()->name,
            "customer_name" => Auth::user()->name,
            "customer_email" => Auth::user()->email,
            "customer_phone" => Auth::user()->phone ?? '',
            "description" => 'Paiement de la commande #' . $order->id,
            "notify_url" => $notify_url,
            "return_url" => $return_url,
            "channels" => 'ALL',
            "customer_phone_number" => Auth::user()->phone ?? '',
            "customer_address" => '',
            "customer_city" => '',
            "customer_country" => 'TG',
            "customer_state" => '',
            "customer_zip_code" => ''
        ];
        
        try {
            $paymentSourceInfo = PaymentGateway::where('vendor_id', $articleInfo->vendor_id ?? 1)->firstOrFail();
            
            if (!$paymentSourceInfo) {
                throw new \Exception('Configuration de paiement non trouvée.');
            }
            
            $CinetPay = new CinetPay($paymentSourceInfo->site_id, $paymentSourceInfo->api_key);
            $result = $CinetPay->generatePaymentLink($paymentData);
            
            if (isset($result['code']) && $result['code'] === '201' && isset($result['data']['payment_url'])) {
                return redirect()->to($result['data']['payment_url']);
            } else {
                throw new \Exception('Erreur lors de la génération du lien de paiement: ' . ($result['description'] ?? 'Erreur inconnue'));
            }
        } catch (\Exception $e) {
            // En cas d'erreur, marquer la commande comme échouée
            $order->status = 'failed';
            $order->save();
            
            return redirect()->back()->with('error', 'Erreur lors du traitement du paiement: ' . $e->getMessage());
        }
        // ($paymentSourceInfo->site_id, $paymentSourceInfo->api_key)
        // dd($result);

        // $url = $result

    }

    /**
     * Affiche la page de paiement
     */
    public function showCheckout(CartService $cartService)
    {
        $cart = $cartService->getCart();
        $summary = $cartService->getSummary();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        return view('checkout.index', [
            'cartItems' => $cart->items,
            'summary' => $summary
        ]);
    }

    /**
     * Traite le paiement
     */
    public function processPayment(Request $request, CartService $cartService)
    {
        $cart = $cartService->getCart();
        $summary = $cartService->getSummary();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        // Créer une nouvelle commande
        $order = new Order();
        $order->user_id = Auth::id();
        $order->total_amount = $summary['total'];
        $order->status = 'pending';
        $order->payment_method = $request->payment_method ?? 'stripe';
        $order->save();

        // Ajouter les articles de la commande
        foreach ($cart->items as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->item_type = get_class($item);
            $orderItem->item_id = $item->id;
            $orderItem->name = $item->name;
            $orderItem->quantity = $item->pivot->quantity;
            $orderItem->price = $item->price;
            $orderItem->total = $item->price * $item->pivot->quantity;
            $orderItem->save();
        }

        // Traitement du paiement avec Stripe
        if ($request->payment_method === 'stripe') {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            
            try {
                $paymentIntent = PaymentIntent::create([
                    'amount' => $order->total_amount * 100, // Montant en centimes
                    'currency' => 'xof',
                    'metadata' => [
                        'order_id' => $order->id,
                        'user_id' => Auth::id(),
                    ],
                ]);

                // Mettre à jour la commande avec l'ID de paiement
                $order->payment_id = $paymentIntent->id;
                $order->save();

                return response()->json([
                    'clientSecret' => $paymentIntent->client_secret,
                    'order_id' => $order->id
                ]);

            } catch (\Exception $e) {
                // En cas d'erreur, annuler la commande
                $order->status = 'failed';
                $order->save();
                
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            }
        }
        // Autres méthodes de paiement peuvent être ajoutées ici
        
        // Si aucune méthode de paiement valide n'est sélectionnée
        return redirect()->back()->with('error', 'Méthode de paiement non valide.');
    }

    /**
     * Page de succès du paiement
     */
    public function paymentSuccess(Request $request)
    {
        $orderId = $request->query('order');
        $order = Order::findOrFail($orderId);

        return view('checkout.success', [
            'order' => $order
        ]);
    }

    /**
     * Page d'annulation du paiement
     */
    public function paymentCancel()
    {
        return view('checkout.cancel');
    }

    /**
     * Notification de paiement (webhook)
     */
    /**
     * Traite les notifications de paiement (webhook)
     */
    public function handleNotification(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');
        
        try {
            $event = Webhook::constructEvent(
                $payload, 
                $sigHeader, 
                $endpointSecret
            );
        } catch (\UnexpectedValueException $e) {
            // Payload invalide
            return response('Payload invalide', 400);
        } catch (SignatureVerificationException $e) {
            // Signature invalide
            return response('Signature invalide', 400);
        }
        
        // Gérer l'événement de paiement réussi
        if ($event->type === 'payment_intent.succeeded') {
            $paymentIntent = $event->data->object;
            
            // Récupérer la commande associée
            $order = Order::where('payment_id', $paymentIntent->id)->first();
            
            if ($order) {
                // Mettre à jour le statut de la commande
                $order->status = 'completed';
                $order->payment_status = 'paid';
                $order->save();
                
                // Vider le panier après un paiement réussi
                if (Auth::check()) {
                    Cart::where('user_id', Auth::id())->delete();
                } else {
                    session()->forget('cart');
                }
                
                // Envoyer un email de confirmation au client
                // Mail::to($order->user->email)->send(new OrderConfirmation($order));
            }
        } 
        // Gérer d'autres types d'événements si nécessaire
        
        return response()->json(['status' => 'success']);
    }
}
