<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDossierMedicalsTable extends Migration
{
    public function up()
    {
        Schema::create('dossier_medicals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->date('date_consultation');
            $table->string('medecin_aps_nom');
            $table->string('motif_consultation');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dossier_medicals');
    }
}
