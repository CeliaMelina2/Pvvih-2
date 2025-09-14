<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Traitement extends Model
{
    use HasFactory;

    // Le nom de la table est 'traitements' par convention, mais on peut le spécifier pour plus de clarté
    protected $table = 'traitements';

    protected $fillable = [
        'patient_id',
        'nom_medicament',
        'posologie',
        'date_debut',
        'date_fin_prevue',
        'frequence',
    ];
}
