<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorAuthController extends Controller
{
    
    public function login()
    {
        return view('auth.vendors.login');
    }
    public function register()
    {
        return view('auth.vendors.register');
    }


    public function handleRegister(Request $request){
          // dd($request);
       $request->validate([
        'name'=>'required',
        'email'=>'required|unique:vendors,email',
        'password'=>'required|min:4',
       ],  [
        'name.required' =>'Votre nom est requis',
        'email.required' =>'Adresse email requise',
        'email.unique' =>'Cette adresse email est deja prise',
        'password.required'=> 'Le mot de passe est requis',
        'password.min'=>'Le mot de passe doit avoir au mois 4 caractères'
       ]);
       try {
    Vendor::create([
        "name" => $request->name,
        "email" => $request->email,
        "password" => Hash::make ($request->password),
    ]);
    return redirect()->back()->with('success', "Votre compte vendeur a été créé.Connectez vous");
       } catch(Exception $e) {
        dd($e);
       }
    }

    public function handleLogin (Request $request){
        $request->validate([
            
            'email'=>'required|exists:vendors,email',
            'password'=>'required|min:4',
           ],  [
           'email.required' =>'Adresse email requise',
            'email.exists'=>'Cette adresse mail n\'est pas reconnue',
           'password.required'=> 'Le mot de passe est requis',
            'password.min'=>'Le mot de passe doit avoir au mois 4 caractères'
           ]);

           try{
            // $credentials= $request -> only (['email', 'password']);
            // if(Auth::attempt($credentials)){
                // return redirect('vendors/dashboard');

            
            if(auth('vendor')->attempt($request->only('email',
            'password'))){
                return redirect('vendors/dashboard');
                
            }else{
                return redirect()->back()->with('error','Information de connexion de compte boutique non reconnue');

            }
            

           }catch(Exception $e){
            dd($e);

           }
    }
}
