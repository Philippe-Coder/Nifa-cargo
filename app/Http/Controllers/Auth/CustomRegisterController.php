<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;

class CustomRegisterController extends Controller
{
    /**
     * Afficher le formulaire d'inscription client
     */
    public function showClientRegister()
    {
        return view('auth.register-client');
    }

    /**
     * Afficher le formulaire d'inscription admin (protégé)
     */
    public function showAdminRegister()
    {
        // Vérifier si l'utilisateur est déjà admin ou si c'est le premier admin
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            // Vérifier s'il y a déjà des admins dans le système
            $adminExists = User::where('role', 'admin')->exists();
            
            if ($adminExists) {
                abort(403, 'Accès non autorisé. Seuls les administrateurs peuvent créer d\'autres comptes administrateur.');
            }
        }
        
        return view('auth.register-admin');
    }

    /**
     * Traiter l'inscription client
     */
    public function registerClient(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telephone' => ['required', 'string', 'max:20'],
            'adresse' => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'password' => Hash::make($request->password),
            'role' => 'client', // Forcer le rôle client
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Compte client créé avec succès ! Bienvenue chez NIF CARGO.');
    }

    /**
     * Traiter l'inscription admin
     */
    public function registerAdmin(Request $request)
    {
        // Double vérification de sécurité
        if (Auth::check() && !Auth::user()->isAdmin()) {
            $adminExists = User::where('role', 'admin')->exists();
            if ($adminExists) {
                abort(403, 'Accès non autorisé.');
            }
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telephone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'admin_key' => ['required', 'string'], // Clé secrète pour créer un admin
        ]);

        // Vérifier la clé secrète admin (vous pouvez la changer)
        if ($request->admin_key !== 'NIF_ADMIN_2024') {
            return back()->withErrors(['admin_key' => 'Clé administrateur invalide.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Forcer le rôle admin
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('admin.dashboard')->with('success', 'Compte administrateur créé avec succès !');
    }
}
