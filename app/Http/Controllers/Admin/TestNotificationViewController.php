<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemandeTransport;

class TestNotificationViewController extends Controller
{
    public function index()
    {
        // Récupérer les demandes avec leurs utilisateurs
        $demandes = DemandeTransport::with('user')
                    ->latest()
                    ->limit(10)
                    ->get();
        
        return view('admin.test-notifications', compact('demandes'));
    }
}