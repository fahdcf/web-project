<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('student_notes', function (Blueprint $table) {
            $table->id();

            $table->integer('module_id')->nullable();
            $table->foreign('module_id')->references('id')->on('modules')->cascadeOnDelete();


            $table->integer('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students')->cascadeOnDelete();



            $table->foreignId('note_id')->nullable()->constrained('notes')->cascadeOnDelete(); // Link to the upload event
            $table->decimal('note', 5, 2); // e.g., 15.75 out of 20


            $table->string('remarque', 255)->nullable();

            $table->enum('session_type', ['normale', 'rattrapage']);
            $table->string('semester', 10);
            $table->timestamps();

            // Ensure a student can only have one grade per module, session, and semester
            $table->unique(['student_id', 'module_id', 'session_type', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_notes');
    }
};
