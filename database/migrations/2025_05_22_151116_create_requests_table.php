<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prof_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('prof_id');
            $table->integer('module_id');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            
            // New columns
            $table->boolean('toTeach_cm')->default(false);
            $table->boolean('toTeach_td')->default(false);
            $table->boolean('toTeach_tp')->default(false);
            $table->integer('action_by')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('prof_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('action_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
