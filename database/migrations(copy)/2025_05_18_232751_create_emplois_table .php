<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration



{
    public function up()
    {
        Schema::create('emplois', function (Blueprint $table) {
            $table->integer('id', true);

            $table->integer('filiere_id')->nullable();
            $table->foreign('filiere_id')->references('id')->on('filieres')->cascadeOnDelete();

            $table->unsignedTinyInteger('semester'); // Peut contenir 1-6 (et plus si besoin)

            $table->string('academic_year', 9); // Format "2023-2024"            

            $table->string('name');

            
            $table->string('file_path')->nullable(); // Pour stocker un fichier PDF/Excel
            $table->boolean('is_active')->nullable()->default(true);

            $table->timestamps();
            
            // Index composite pour les requêtes fréquentes
            $table->index(['filiere_id', 'semester', 'academic_year']);

        });

        
    }

    public function down()
    {
        Schema::dropIfExists('emplois');

    }
};
