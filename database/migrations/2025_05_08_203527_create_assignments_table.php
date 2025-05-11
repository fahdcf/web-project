<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            // Clés étrangères

            $table->integer('module_id');
            $table->foreign('module_id')->references('id')->on('modules')->cascadeOnDelete();

            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();



            // Métadonnées
            $table->string('role')->default('professeur'); // 'professeur' ou 'vacataire'
            $table->string('status')->default('proposed'); // 'proposed', 'validated', 'rejected'
            $table->text('rejection_reason')->nullable();

            // Timestamps
            $table->timestamps();

            // Contrainte d'unicité
            $table->unique(['module_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
