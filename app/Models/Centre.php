<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Centre extends Model
{

    use HasFactory;

    protected $table = 'centres';

    protected $fillable = [
        'nom',
        'ville',
        'localisation',
        'responsable',
    ];

    public function transferts()
    {
        return $this->hasMany(Transfert::class);
    }

}
