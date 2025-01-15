<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateway;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function getAccountInfo()
    {
        $vendorId = auth('vendor')->user()->id;
        $paymentInfo = PaymentGateway::where('vendor_id', $vendorId)->first();

        return view('dashboard.vendors.manage.payment', compact('paymentInfo'));
    }
    public function handleUpdateInfo(Request $request)
    {

        // DB::beginTransaction();
        // dd($request);
        // Validate the request data
        $request->validate(
            [
                'site_id' => 'required',
                'api_key' => 'required',
                'secret_key' => 'required',
            ],
            [
                // Customize error messages
                'site_id.required' => 'L\' ID du site est obligatoire',
                'api_key.required' => 'L\'API Key est obligatoire',
                'secret_key.required' => 'Le Secret Key est obligatoire',
            ]
        );
        try {
            $vendorId = auth('vendor')->user()->id;

            $existingAccount = PaymentGateway::where('vendor_id', $vendorId)->first();
            if ($existingAccount) {
                $existingAccount ->site_id = $request -> site_id;
                $existingAccount ->api_key = $request -> api_key;
                $existingAccount ->secret_key = $request -> secret_key;
                $existingAccount ->update();
            } else {
                PaymentGateway::create([
                    'vendor_id' => $vendorId,
                    'site_id' => $request->site_id,
                    'api_key' => $request->api_key,
                    'secret_key' => $request->secret_key,
                ]);
            }

            return redirect()->back()->with('success', 'Donnée enregistrée');

            // DB::commit();
            // return redirect()->back()->with('success', 'Donnée enregistrée');
        } catch (Exception $e) {
            dd($e);
            // DB::rollback();
        }
    }
}
