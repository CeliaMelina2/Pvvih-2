<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Formulaire d'inscription patient
    public function showPatientForm()
    {
        return view('inscription_patient');
    }

    // Enregistrement patient
    public function registerPatient(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
              'sexe' => 'required|string', // ✅ ajouté
            'telephone' => 'required|string|max:20',
            'adresse' => 'required|string|max:255',
            'statut_serologique' => 'required|string',
            'date_diagnostic' => 'required|date',
            'codeTARV' => 'required|string|max:50',
            'attestation' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Gestion du fichier attestation
        $attestation = null;
        if ($request->hasFile('attestation')) {
            $file = $request->file('attestation');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/attestations', $filename);
            $attestation = $filename;
        }

            // Création de l'utilisateur
        $user = User::create([
            'name' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'patient',
        ]);

        // S'assurer que l'utilisateur a bien été créé avant de créer le patient
        if ($user) {
            $patient = Patient::create([
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'telephone' => $validated['telephone'],
                'adresse' => $validated['adresse'],
                'sexe' => $validated['sexe'], // ✅ ajouté
                'statut_serologique' => $validated['statut_serologique'],
                'date_diagnostic' => $validated['date_diagnostic'],
                'codeTARV' => $validated['codeTARV'],
                'attestation' => $attestation ?? null,
                'user_id' => $user->id, // clé étrangère obligatoire
            ]);
        }


        // Connexion automatique
        Auth::login($user);

        return redirect()->route('patient.dashboard')
            ->with('success', 'Bienvenue ' . $user->name . ' ! Vous êtes connecté.');
    }

    // Formulaire de connexion
    public function showLoginForm()
    {
        return view('connexion');
    }

    // Login général (sans guard)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
         
            // Vérification du rôle
            if ($user->role === 'patient') {
                return redirect()->route('patient.dashboard')
                    ->with('success', 'Bienvenue ' . $user->name . ' !');
            } elseif ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Bienvenue ' . $user->name . ' !');
            } elseif ($user->role === 'aps') {
                return redirect()->route('aps.dashboard')
                    ->with('success', 'Bienvenue ' . $user->name . ' !');
            } else {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Rôle inconnu. Contactez l’administrateur.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ]);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('connexion');
    }
}
