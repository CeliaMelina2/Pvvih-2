<?php

namespace App\Http\Controllers;

use App\Models\Aps;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApsController extends Controller
{
    // Liste des APS
    public function index()
    {
        return response()->json(Aps::all());
    }

    // Formulaire inscription (si Blade)
    public function create()
    {
        return view('inscription_aps');
    }

    // Sauvegarder un APS
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'sexe' => 'required',
            'telephone' => 'required|unique:aps',
            'email' => 'required|email|unique:aps',
            'password' => 'required|min:8',
        ]);

        $aps = Aps::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'sexe' => $request->sexe,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'attestation_fonction' => $request->attestation_fonction,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

     $user = User::create([
        'name' => $request->nom,          // correspond à la colonne "name"
        'prenom' => $request->prenom,     // ajouter "prenom" dans $fillable
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'aps',
    ]);


        return redirect()->route('accueil');
    }

    // Afficher un APS
    public function show($id)
    {
        return Aps::findOrFail($id);
    }

    // Modifier un APS
    public function update(Request $request, $id)
    {
        $aps = Aps::findOrFail($id);
        $aps->update($request->all());
        return response()->json($aps);
    }

    // Supprimer un APS
    public function destroy($id)
    {
        Aps::destroy($id);
        return response()->json(['message' => 'APS supprimé']);
    }
}
