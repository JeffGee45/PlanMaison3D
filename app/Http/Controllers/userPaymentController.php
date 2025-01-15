<?php

namespace App\Http\Controllers;

use App\Helpers\CinetPay;
use App\Models\PaymentGateway;
use Illuminate\Support\Str;

use App\Models\Product;
use App\Models\Products;
use Illuminate\Http\Request;

class userPaymentController extends Controller
{
    public function initPayment($id){
       
        $articleInfo = Products::find($id);
        // dd($articleInfo);
        $notify_url = 'http://localhost:8000/articles/order/17';
        $return_url = 'http://localhost:8000/articles/order/17';

        $paymentData = array(
            "transaction_id" => Str::random(40),
            "amount" => $articleInfo->price,
            "currency" => 'XOF',
            "customer_surname" => 'john',
            "customer_name" => 'doe',
            "description" => 'paiement de l\'article'. $articleInfo->name,
            "notify_url" => $notify_url,
            "return_url" => $return_url,
            "channels" => 'ALL',
            "invoice_data" =>[],
            "metadata" => "", // utiliser cette variable pour recevoir des informations personnalisés.
            "alternative_currency" => "", //Valeur de la transaction dans une devise alternative
            //Fournir ces variables obligatoirement pour le paiements par carte bancaire
            "customer_email" => "", //l'email du client
            "customer_phone_number" => "", //Le numéro de téléphone du client
            "customer_address" => "", //l'adresse du client
            "customer_city" => "", // ville du client
            "customer_country" => "", //Le pays du client, la valeur à envoyer est le code ISO du pays (code à deux chiffre) ex : CI, BF, US, CA, FR
            "customer_state" => "", //L’état dans de la quel se trouve le client. Cette valeur est obligatoire si le client se trouve au États Unis d’Amérique (US) ou au Canada (CA)
            "customer_zip_code" => "" //Le code postal du client
        );
        $paymentSourceInfo = PaymentGateway::where('vendor_id', $articleInfo->vendor_id)->first();
        $CinetPay = new CinetPay($paymentSourceInfo->site_id, $paymentSourceInfo->api_key);

        $result = $CinetPay->generatePaymentLink($paymentData);

        $url = $result['data']['payment_url'];

        return redirect()->to($url);
        // ($paymentSourceInfo->site_id, $paymentSourceInfo->api_key)
        // dd($result);

        // $url = $result

    }
}
