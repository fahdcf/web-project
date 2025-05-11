<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('prof_id');
            $table->unsignedBigInteger('target_id');
            $table->enum('type', ['module', 'filiere', 'departement']);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            // Foreign key to users table (assumes professors are users)

            $table->foreign('prof_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
