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
        Schema::create('user_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->index('user_id');
            $table->enum('sexe', ['male', 'female'])->nullable();
            $table->string('cin')->nullable();
            $table->string('adresse')->nullable();
            $table->string('profile_img')->nullable();
            $table->string('number', 20)->nullable();
            $table->enum('status', ['active', 'inactive'])->nullable()->default('active');
            $table->integer('hours')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
