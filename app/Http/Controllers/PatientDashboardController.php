<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Patient;

class PatientDashboardController extends Controller
{
    public function index()
    {
        // Récupérer le patient connecté
        $patient = Auth::user();

        return view('patient.dashboard', compact('patient'));
    }
}
