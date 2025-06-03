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
        Schema::create('assignments', function (Blueprint $table) {
            $table->integer('id', true);

            $table->integer('module_id')->nullable();
            $table->foreign('module_id')->references('id')->on('modules')->cascadeOnDelete()->nullable();

            $table->integer('prof_id')->nullable();
            $table->foreign('prof_id')->references('id')->on('users')->cascadeOnDelete()->nullable();

            $table->integer('hours')->nullable();

            $table->boolean('teach_cm')->nullable()->default(false);
            $table->boolean('teach_tp')->nullable()->default(false);
            $table->boolean('teach_td')->nullable()->default(false);

            $table->string('academic_year')->nullable(); // e.g., "2023-2024"



            $table->timestamps();
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
