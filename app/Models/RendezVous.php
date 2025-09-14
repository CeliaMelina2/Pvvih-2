<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RendezVous extends Model
{
    use HasFactory;

    // Définir le nom de la table
    protected $table = 'rendez_vous';

    protected $fillable = [
        'patient_id',
        'aps_id',
        'medecin_nom',
        'date_heure',
        'motif',
        'statut',
    ];
}
