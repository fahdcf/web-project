<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('module_id')->constrained('modules')->onDelete('cascade');
            $table->string('semester', 10); // S1, S2, etc.
            $table->enum('session_type', ['normale', 'rattrapage']);
            $table->decimal('note', 4, 2)->nullable(); // 18.50 (nullable for cases where student didn't take exam)
            $table->text('remarks')->nullable();
            $table->timestamps();

            // Composite unique index
            $table->unique(['student_id', 'module_id', 'semester', 'session_type']);

            // Additional indexes for performance
            $table->index('module_id');
            $table->index('semester');
            $table->index('session_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};