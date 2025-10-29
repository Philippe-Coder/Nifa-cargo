<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        $available = ['fr', 'en', 'zh_CN']; 

        if (in_array($locale, $available)) {
            // Sauvegarder dans la session
            session(['locale' => $locale]);
            
            // Définir immédiatement la locale pour cette requête
            App::setLocale($locale);
            
            // Forcer la sauvegarde de la session
            session()->save();
            
            // Log pour debug
            Log::info("Changement de langue vers: " . $locale);
            Log::info("Session locale: " . session('locale'));
            Log::info("App locale: " . App::getLocale());
        } else {
            Log::warning("Tentative de changement vers une locale non supportée: " . $locale);
        }

        return redirect()->back(); 
    }
}