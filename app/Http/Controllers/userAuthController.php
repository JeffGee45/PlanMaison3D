<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class userAuthController extends Controller
{
    public function register()
    {
        return view('auth.users.register');
    }
    public function login(){
        return view('auth.users.login');
    }

    
    public function handleRegister(Request $request)
    {
        // dd($request);
       $request->validate([
        'name'=>'required',
        'email'=>'required|unique:users,email',
        'password'=>'required|min:4',
       ],  [
        'name.required' =>'Votre nom est requis',
        'email.required' =>'Adresse email requise',
        'email.unique' =>'Cette adresse email est deja prise',
        'password.required'=> 'Le mot de passe est requis',
        'password.min'=>'Le mot de passe doit avoir au mois 4 caractères'
       ]);
       try {
    User::create([
        "name" => $request->name,
        "email" => $request->email,
        "password" => Hash::make ($request->password),
    ]);
    return redirect()->back()->with('success', "Votre compte a été créé");
       } catch(Exception $e) {
        dd($e);
       }
    }

    public function handleLogin (Request $request){
        $request->validate([
            
            'email'=>'required|exists:users,email',
            'password'=>'required|min:4',
           ],  [
           'email.required' =>'Adresse email requise',
            'email.exists'=>'Cette adresse mail n\'est pas reconnue',
           'password.required'=> 'Le mot de passe est requis',
            'password.min'=>'Le mot de passe doit avoir au mois 4 caractères'
           ]);

           try{
            if(auth()->attempt($request->only('email','password')))
            {
                //Rediriger sur la page d'acceuil
                return redirect('/');
            }else{
                return redirect()->back()->with('error',
                'Information de connexion non reconnue');
            }

           }catch(Exception $e){

           }
    }
    public function  handleLogout(){
        Auth::logout();
        return redirect('/');
    }
}
