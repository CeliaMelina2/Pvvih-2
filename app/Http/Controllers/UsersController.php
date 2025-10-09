<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        $totalUsers = User::count();
        $adminCount = User::where('role_user', 'admin')->count();
        $apsCount = User::where('role_user', 'aps')->count();
        $patientCount = User::where('role_user', 'patient')->count();

        return view('admin.utilisateurs', compact(
            'users', 'totalUsers', 'adminCount', 'apsCount', 'patientCount'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'role_user' => 'required|in:admin,aps,patient',
        ]);

        User::create($request->all());

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur créé avec succès !');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'prenom' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_user' => 'required|in:admin,aps,patient',
        ]);

        $user->update($request->all());

        return redirect()->route('admin.utilisateurs')->with('success', 'Utilisateur modifié avec succès !');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.utilisateurs')->with('success', 'Utilisateur supprimé avec succès !');
    }

    public function toggleStatus(User $user)
    {
        $user->update([
            'statut' => $user->statut === 'actif' ? 'inactif' : 'actif'
        ]);

        return redirect()->back()->with('success', 'Statut utilisateur mis à jour !');
    }
}