<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        $available = ['fr', 'en', 'zh_CN']; 

        if (in_array($locale, $available)) {
            session(['locale' => $locale]);
        }

        return redirect()->back(); 
    }
}