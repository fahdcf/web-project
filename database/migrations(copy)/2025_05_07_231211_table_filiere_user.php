<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('filiere_user', function (Blueprint $table) {
            // Explicitly define the column type to match users.id
            $table->integer('user_id');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->integer('filiere_id');
            $table
                ->foreign('filiere_id')
                ->references('id')
                ->on('filieres')
                ->cascadeOnDelete();

            $table->timestamps();

            // Add composite primary key
            $table->primary(['user_id', 'filiere_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professor_filiere');
    }
};
