<?php

namespace App\Http\Controllers;

use App\Models\CloudFile;
use App\Models\Products;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    public function index(){
        $articles = Products::where('vendor_id',auth('vendor')->user()->id)-> latest()->get();
        return view ('dashboard.vendors.articles.index', compact
        ('articles'));
    }

    public function create(){

     return view ('dashboard.vendors.articles.create');
    }

    public function handleCreate(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'nullable|exists:categories,id'
        ], [
            'name.required' => 'Le nom du plan est requis',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères',
            'description.required' => 'La description du plan est requise',
            'price.required' => 'Le prix du plan est requis',
            'price.numeric' => 'Le prix doit être un nombre',
            'price.min' => 'Le prix ne peut pas être négatif',
            'image.image' => 'Le fichier doit être une image',
            'image.mimes' => 'Les formats d\'image acceptés sont : jpeg, png, jpg, gif',
            'image.max' => 'L\'image ne doit pas dépasser 2 Mo',
            'category_id.exists' => 'La catégorie sélectionnée n\'est pas valide'
        ]);

        // Démarrer une transaction de base de données
        DB::beginTransaction();

        try {
            // Créer un nouveau produit
            $product = new Products();
            $product->name = $validatedData['name'];
            $product->description = $validatedData['description'];
            $product->price = $validatedData['price'];
            $product->vendor_id = auth('vendor')->id();
            $product->status = true; // Par défaut, le produit est actif
            
            // Gérer l'upload de l'image si elle est fournie
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('public/images/articles');
                $product->image = str_replace('public/', '', $imagePath);
            } else {
                $product->image = 'images/default-article.jpg';
            }
            
            // Sauvegarder le produit
            $product->save();

            // Valider la transaction
            DB::commit();

            // Rediriger avec un message de succès
            return redirect()
                ->route('articles.index')
                ->with('success', 'Le plan a été créé avec succès.');
                
        } catch (\Exception $e) {
            // En cas d'erreur, annuler la transaction
            DB::rollBack();
            
            // Journaliser l'erreur
            Log::error('Erreur lors de la création du plan : ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            // Rediriger avec un message d'erreur
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Une erreur est survenue lors de la création du plan : ' . $e->getMessage());
        }
    }
}