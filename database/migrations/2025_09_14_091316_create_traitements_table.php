<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraitementsTable extends Migration
{
    public function up()
    {
        Schema::create('traitements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->string('nom_medicament');
            $table->string('posologie');
            $table->date('date_debut');
            $table->date('date_fin_prevue')->nullable();
            $table->string('frequence')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('traitements');
    }
}