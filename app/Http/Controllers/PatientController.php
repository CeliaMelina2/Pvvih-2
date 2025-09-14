<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;
use App\Models\User;


class PatientAuthController extends Controller
{
    // Formulaire d'inscription patient
    public function showRegistrationForm()
    {
        return view('auth.inscription_patient');
    }

    // Enregistrement patient
    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patients',
            'password' => 'required|string|confirmed|min:8',
            'sexe' => 'required|string',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'statut_serologique' => 'required|string',
            'date_diagnostic' => 'required|date',
            'codeTARV' => 'required|string|max:50',
        ]);

        $patient = Patient::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'sexe' => $request->sexe,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'statut_serologique' => $request->statut_serologique,
            'date_diagnostic' => $request->date_diagnostic,
            'codeTARV' => $request->codeTARV,
        ]);

        $user = User::create([
            'name' => $request->nom,          // correspond à la colonne "name"
            'prenom' => $request->prenom,     // ajouter "prenom" dans $fillable
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'aps',
        ]);

        return redirect()->route('connexion')
                         ->with('success', 'Inscription réussie ! Veuillez vous connecter.');
    }
}
