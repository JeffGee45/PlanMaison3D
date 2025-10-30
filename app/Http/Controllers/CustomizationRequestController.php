<?php

namespace App\Http\Controllers;

use App\Models\HousePlan;
use App\Models\CustomizationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomizationRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new customization request.
     *
     * @param  string|int  $plan Le slug ou l'ID du plan à personnaliser
     * @return \Illuminate\View\View
     */
    public function create($plan)
    {
        // Récupérer le plan par son slug ou son ID avec les champs nécessaires
        $plan = HousePlan::select([
            'id', 'name', 'slug', 'surface_area', 'bedrooms', 'bathrooms', 'floors', 'price', 
            'plan_2d_path', 'image_path', 'panorama_image_path', 'is_published', 'style', 'description'
        ])->where('slug', $plan)
          ->orWhere('id', $plan)
          ->firstOrFail();
        
        // Vérifier et corriger les chemins d'images manquants
        $this->ensureImagePathsExist($plan);
        
        return view('customization-requests.create', compact('plan'));
    }
    
    /**
     * Vérifie et corrige les chemins d'images manquants
     */
    protected function ensureImagePathsExist($plan)
    {
        // Définir les chemins par défaut
        $default_image = 'images/default/default-image.jpg';
        $default_panorama = 'images/default/default-panorama.jpg';

        // Vérifier l'image de présentation
        if (empty($plan->image_path) || !file_exists(public_path($plan->image_path))) {
            $plan->image_path = $default_image;
        }
        
        // Vérifier le plan 2D
        if (empty($plan->plan_2d_path) || !file_exists(public_path($plan->plan_2d_path))) {
            $plan->plan_2d_path = null; // Pas d'image par défaut pour le plan 2D, on le cache
        }
        
        // Vérifier l'image panoramique
        if (empty($plan->panorama_image_path) || !file_exists(public_path($plan->panorama_image_path))) {
            $plan->panorama_image_path = $default_panorama;
        }
        
        return $plan;
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * Store a newly created customization request in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'house_plan_id' => 'required|exists:house_plans,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'message' => 'required|string|min:10|max:2000',
        ]);

        $customizationRequest = CustomizationRequest::create($validated);

        // Récupérer le plan avec son slug pour la redirection
        $plan = HousePlan::findOrFail($customizationRequest->house_plan_id);

        // Vérifier si le plan a un slug valide
        if (empty($plan->slug)) {
            // Si le slug est vide, utiliser l'ID comme fallback
            return redirect()
                ->route('house-plans.show', $plan->id)
                ->with('success', 'Votre demande de personnalisation a été envoyée avec succès. Nous vous contacterons bientôt !');
        }

        return redirect()
            ->route('house-plans.show', $plan->slug)
            ->with('success', 'Votre demande de personnalisation a été envoyée avec succès. Nous vous contacterons bientôt !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
