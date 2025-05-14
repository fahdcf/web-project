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

            $table->integer('cm_hours')->nullable();
            $table->integer('tp_hours')->nullable();
            $table->integer('td_hours')->nullable();
            $table->integer('autre_hours')->nullable();

            // Relations avec foreignIdFor()

            $table->integer('filiere_id')->nullable();

            $table->integer('semester')->nullable();

            $table->foreign('filiere_id')->references('id')->on('filieres')->cascadeOnDelete();

            
            $table->integer('responsable_id')->nullable();
            
            $table->integer('professor_id')->nullable();
            $table->foreign('professor_id')->references('id')->on('users')->cascadeOnDelete()->nullable();

              $table->integer('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('modules')->cascadeOnDelete()->nullable();
            // /

            $table->integer('nb_groupes_td')->nullable();
            $table->integer('nb_groupes_tp')->nullable();

            // $table->integer('status')->nullable()->default(null)->comment('0=Inactif, 1=Actif, null=draft');
            $table->enum('status', ['active', 'inactive', 'draft'])->default('draft');

            //sous_module ou module complet
            $table->enum('type', ['element', 'complet'])->default('complet');



            $table->integer('credits')->nullable();
            $table->integer('evaluation')->nullable();

            // Index pour les performances
            $table->index('filiere_id');
            $table->index('professor_id');
            $table->index('responsable_id');


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('modules');
    }
};
