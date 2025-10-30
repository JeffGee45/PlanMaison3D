<?php

namespace App\Http\Controllers;

use App\Models\HousePlan;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class HousePlanController extends Controller
{
    public function index(Request $request)
    {
        $query = HousePlan::query()->where('is_published', true);

        // Filtrage par style
        if ($request->filled('style')) {
            $query->where('style', $request->input('style'));
        }

        // Filtrage par nombre de chambres
        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', $request->input('bedrooms'));
        }

        // Filtrage par prix
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        // Filtrage par superficie
        if ($request->filled('surface_min')) {
            $query->where('surface_area', '>=', $request->input('surface_min'));
        }
        if ($request->filled('surface_max')) {
            $query->where('surface_area', '<=', $request->input('surface_max'));
        }

        // Récupérer les paramètres de requête actuels pour les conserver dans la pagination
        $queryParams = $request->query();
        
        // Appliquer le tri et la pagination
        $plans = $query->latest()->paginate(12)->appends($queryParams);
        
        // Ajout d'une vérification pour chaque plan
        foreach ($plans as $plan) {
            $this->ensureImagePathsExist($plan);
        }

        // Récupérer les options de filtre pour la vue
        $styles = HousePlan::where('is_published', true)->distinct()->pluck('style')->filter()->sort();
        
        return view('house-plans.index', [
            'plans' => $plans,
            'styles' => $styles,
            'filters' => $request->all(), // Pour conserver les filtres dans le formulaire
        ]);
    }

    public function show($plan)
    {
        // Récupérer le plan par son slug ou son ID
        $plan = HousePlan::where('slug', $plan)
            ->orWhere('id', $plan)
            ->firstOrFail();
            
        $this->ensureImagePathsExist($plan);
        return view('house-plans.show', compact('plan'));
    }

    public function downloadPDF(HousePlan $plan)
    {
        $this->ensureImagePathsExist($plan);

        $pdf = Pdf::loadView('house-plans.pdf', compact('plan'));
        
        return $pdf->download($plan->slug . '.pdf');
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
        if (empty($plan->image_path) || !File::exists(public_path($plan->image_path))) {
            $plan->image_path = $default_image;
        }
        
        // Vérifier le plan 2D
        if (empty($plan->plan_2d_path) || !File::exists(public_path($plan->plan_2d_path))) {
            $plan->plan_2d_path = null; // Pas d'image par défaut pour le plan 2D, on le cache
        }
        
        // Vérifier l'image panoramique
        if (empty($plan->panorama_image_path) || !File::exists(public_path($plan->panorama_image_path))) {
            $plan->panorama_image_path = $default_panorama;
        }
        
        return $plan;
    }
}
