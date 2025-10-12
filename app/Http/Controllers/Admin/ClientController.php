<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = User::where('role', 'client')
            ->withCount('demandes')
            ->latest()
            ->paginate(10);
            
        return view('admin.clients.index', compact('clients'));
    }

    public function show($id)
    {
        $client = User::with('demandes')->findOrFail($id);
        return view('admin.clients.show', compact('client'));
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->back()->with('success', 'Client supprimé avec succès.');
    }
}
