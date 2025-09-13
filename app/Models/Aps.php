namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aps extends Model
{
    use HasFactory;

    protected $primaryKey = 'idAPS';

    protected $fillable = [
        'nom',
        'prenom',
        'sexe',
        'telephone',
        'adresse',
        'attestation_fonction',
        'email',
        'password'
    ];

    protected $hidden = ['password'];
}
