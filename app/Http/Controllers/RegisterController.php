<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class RegisterController extends Controller
{
    // Formulaire patient
    public function showPatientForm()
    {
        return view('inscription_patient');
    }

    // Enregistrement patient
    public function registerPatient(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'sexe' => 'required|string',
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'statut_serologique' => 'required|string',
            'date_diagnostic' => 'required|date',
            'codeTARV' => 'required|string|max:50',
        ]);

        $user = User::create([
            'name' => $request->nom . ' ' . $request->prenom,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);



    // ✅ Connexion automatique
    Auth::login($user);

    // ✅ Redirection directe vers le dashboard
    return redirect()->route('patient.dashboard')
        ->with('success', 'Bienvenue ' . $user->name . ' ! Vous êtes connecté.');
    }
        public function showLoginForm()
    {
        return view('connexion');
    }
   public function login(Request $request)
    {
        // ✅ validation simple (pas de unique ici)
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ✅ on récupère l’utilisateur
            $user = Auth::user();

            return redirect()->route('patient.dashboard')
                ->with('success', 'Bienvenue ' . $user->name . ' ! Vous êtes connecté.');
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ]);
    }


}
