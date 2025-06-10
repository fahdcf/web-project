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

            $table->integer('module_id')->nullable();
            $table->foreign('module_id')->references('id')->on('modules')->cascadeOnDelete();

            $table->integer('prof_id')->nullable();
            $table->foreign('prof_id')->references('id')->on('users')->cascadeOnDelete();

            $table->enum('session_type', ['normale', 'rattrapage']);

            $table->string('semester', 10);
            $table->string('storage_path')->nullable();
            $table->string('original_name')->nullable();




            
            $table->enum('status', ['active', 'canceled'])->default('active');
            $table->timestamp('canceled_at')->nullable();



            $table->timestamps();

            // Composite unique index
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
