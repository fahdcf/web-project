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
        Schema::create('students', function (Blueprint $table) {
            $table->integer('id', true);

            $table->string('firstname');
            $table->string('lastname');
            $table->enum('status', ['active', 'inactive'])->nullable()->default('active');
            $table->string('email')->unique('email');
            $table->enum('sexe', ['male', 'female'])->nullable();
            $table->string('cin')->nullable();
            $table->string('CNE')->nullable()->unique('CNE');
            $table->string('adresse')->nullable();
            $table->string('profile_img')->nullable();
            $table->string('number', 20)->nullable();
            $table->date('date_of_birth')->nullable();


            $table->integer('filiere_id')->nullable();
            $table->foreign('filiere_id')->references('id')->on('filieres')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
