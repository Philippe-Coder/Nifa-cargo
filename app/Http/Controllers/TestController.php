<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class TestController extends Controller
{
    public function testLocale()
    {
        $data = [
            'app_locale' => App::getLocale(),
            'session_locale' => Session::get('locale', 'non définie'),
            'config_locale' => config('app.locale'),
            'translation_accueil' => __('Accueil'),
            'translation_services' => __('Services'),
            'translation_contact' => __('Contact'),
            'session_data' => Session::all(),
        ];

        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    public function setTestLocale($locale = 'en')
    {
        $supportedLocales = ['fr', 'en', 'zh_CN'];
        
        if (in_array($locale, $supportedLocales)) {
            Session::put('locale', $locale);
            App::setLocale($locale);
            
            return response()->json([
                'success' => true,
                'locale_set' => $locale,
                'app_locale' => App::getLocale(),
                'session_locale' => Session::get('locale'),
                'translation_test' => __('Accueil')
            ]);
        }
        
        return response()->json(['error' => 'Locale non supportée']);
    }
}