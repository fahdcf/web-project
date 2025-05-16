<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules\Enum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('groupes', function (Blueprint $table) {

            $table->id();

            $table->integer('module_id');
            $table->foreign('module_id')->references('id')->on('modules')->cascadeOnDelete();


            $table->enum('type', ['TP', 'TD']);

            $table->integer('max_students')->nullable()->default(0);
            $table->integer('nbr_student')->nullable()->default(0);

            $table->string('academicYear');//ex2024-2025


            


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groupes');
    }
};
