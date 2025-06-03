<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('code')->nullable()->unique();

            $table->string('name');
            $table->text('description')->nullable();
            $table->string('specialty')->nullable();


            $table->integer('cm_hours')->default(0);
            $table->integer('tp_hours')->default(0);
            $table->integer('td_hours')->default(0);
            $table->integer('autre_hours')->default(0);

            $table->integer('nbr_groupes_td')->default(0);
            $table->integer('nbr_groupes_tp')->default(0);


            $table->integer('filiere_id')->nullable();
            $table->foreign('filiere_id')->references('id')->on('filieres')->cascadeOnDelete();

            $table->integer('semester')->nullable();

            $table->integer('responsable_id')->nullable();

            $table->enum('status', ['active', 'inactive'])->default('active');

            //sous_module ou module complet
            $table->enum('type', ['element', 'complet'])->default('complet');
            $table->integer('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('modules')->cascadeOnDelete()->nullable();


            $table->integer('credits')->nullable();
            $table->integer('evaluation')->nullable();

            // Index pour les performances
            $table->index('filiere_id');
            // $table->index('professor_id');
            $table->index('responsable_id');


            // $table->string('academic_year', 9)->nullable(); // Année académique (format: 2023-2024)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('modules');
    }
};
