<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->integer('prof_id');
            $table->integer('target_id');
            $table->enum('type', ['module', 'filiere', 'departement']);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            // Foreign key to users table (assumes professors are users)

            $table->foreign('prof_id')->references('id')->on('users')->onDelete('cascade');


            // New fields for group preferences
            $table->json('group_types')->nullable(); // Stores which types (CM, TD, TP) the professor wants
            $table->json('td_groups')->nullable();   // Stores specific TD groups if selected
            $table->json('tp_groups')->nullable();   // Stores specific TP groups if selected
            $table->text('comment')->nullable();     // Professor's comment on the request

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
