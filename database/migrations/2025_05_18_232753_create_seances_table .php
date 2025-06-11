<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seances', function (Blueprint $table) {


            $table->integer('id', true);

            $table->integer('module_id')->nullable();
            $table->foreign('module_id')->references('id')->on('modules')->cascadeOnDelete();

            $table->integer('emploi_id')->nullable();
            $table->foreign('emploi_id')->references('id')->on('emplois')->cascadeOnDelete();


            $table->integer('prof_id')->nullable();
            $table->foreign('prof_id')->references('id')->on('users')->cascadeOnDelete();



            $table->enum('type', ['CM', 'TD', 'TP']);
            $table->enum('jour', ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']);

            $table->time('heure_debut');
            $table->time('heure_fin');

            $table->string('salle', 50)->nullable(); //
            $table->string('groupe', 20)->nullable(); // Ex: "TD1", "TP3", "Groupe A"

            $table->timestamps();


            // Contrainte pour éviter les chevauchements
            $table->unique(['emploi_id', 'jour', 'heure_debut', 'salle'], 'emploi_jour_heure_salle_unique');

            // Index pour performances
            $table->index(['emploi_id', 'module_id', 'jour']);
        });
    }



    public function down()
    {

        Schema::dropIfExists('seances');
    }
};
