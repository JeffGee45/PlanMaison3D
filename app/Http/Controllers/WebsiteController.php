<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        $articles = Products::latest()->paginate(20);
        return view('welcome', compact('articles'));
    }

    /**
     * Affiche la page À propos
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Affiche la page Contact
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Traite la soumission du formulaire de contact
     */
    public function handleContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'privacy' => 'accepted',
        ]);

        // Ici, vous pouvez ajouter la logique pour envoyer l'email
        // Par exemple :
        // Mail::to('contact@planmaison3d.tg')->send(new ContactFormMail($validated));

        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
    }
}
