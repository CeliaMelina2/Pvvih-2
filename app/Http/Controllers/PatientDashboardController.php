<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Patient;

class PatientDashboardController extends Controller
{
    public function index()
    {
        $patient = Auth::user();

        return view('patient.dashboard', compact('patient'));
    }
}
