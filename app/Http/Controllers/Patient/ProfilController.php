<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;

class ProfilController extends Controller
{
    /**
     * Affiche la page de profil du patient.
     */
    public function index()
    {
        $patient = Auth::user()->patient;
        $user = Auth::user();

        // Pour la vue, nous avons besoin à la fois des informations du User (email) et du Patient
        return view('patient.profil', compact('patient', 'user'));
    }

    /**
     * Met à jour les informations personnelles du patient.
     */
    public function updateInfo(Request $request)
    {
        $user = Auth::user();
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        $patient = $user->patient;
        $patient->update([
            'contact_urgence_nom' => $request->input('contact_urgence_nom'),
            'contact_urgence_tel' => $request->input('contact_urgence_tel'),
        ]);

        return back()->with('success', 'Informations personnelles mises à jour !');
    }

    /**
     * Met à jour les informations de santé du patient.
     */
    public function updateSante(Request $request)
    {
        $patient = Auth::user()->patient;

        $patient->update([
            'allergies' => $request->input('allergies'),
            // Note: les informations sensibles comme le statut sérologique ne devraient pas être modifiables par le patient lui-même
        ]);

        return back()->with('success', 'Informations de santé mises à jour !');
    }

    /**
     * Change le mot de passe du patient.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Mot de passe mis à jour avec succès !');
    }
}