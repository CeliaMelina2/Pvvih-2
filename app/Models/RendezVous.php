<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use HasFactory;

    protected $table = 'rendez_vous';

    protected $fillable = [
        'patient_id',
        'aps_id',
        'date_heure',
        'motif',
        'statut',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function aps()
    {
        return $this->belongsTo(Aps::class);
    }
}
