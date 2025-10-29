<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        // Locales supportées
        $supportedLocales = ['fr', 'en', 'zh_CN']; 

        // Vérifier si la locale est supportée
        if (in_array($locale, $supportedLocales)) {
            // Sauvegarder la locale dans la session
            Session::put('locale', $locale);
            
            // Définir immédiatement la locale
            App::setLocale($locale);
        }

        // Rediriger vers la page précédente
        return redirect()->back(); 
    }
}