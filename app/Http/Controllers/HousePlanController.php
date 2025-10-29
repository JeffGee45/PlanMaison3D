<?php

namespace App\Http\Controllers;

use App\Models\HousePlan;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class HousePlanController extends Controller
{
    public function index()
    {
        $plans = HousePlan::where('is_published', true)->latest()->paginate(12);
        
        // Ajout d'une vérification pour chaque plan
        $plans->each(function($plan) {
            $this->ensureImagePathsExist($plan);
        });
        
        return view('house-plans.index', compact('plans'));
    }

    public function show(HousePlan $plan)
    {
        $this->ensureImagePathsExist($plan);
        return view('house-plans.show', compact('plan'));
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
