<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;
use App\Models\User;


class ProfileController extends Controller
{
    public function patientclient(){
        $user = Auth::user();

        if(!$user){
            return redirect()->route('homepagelogin');
        }

        $user = Patient::where('id', $user->id);

        return view('patient.profil', compact('user'));
    }
}
