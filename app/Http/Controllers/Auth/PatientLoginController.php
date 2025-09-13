<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.patient_login'); // Vue du formulaire de connexion
    }

    public function login(Request $request)
    {
        // Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Tentative de connexion via le guard patient
        if (Auth::guard('web')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return redirect()->route('patient.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return redirect()->route('patient.login');
    }
}
