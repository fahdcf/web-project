<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prof_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('prof_id')->nullable();
            $table->foreign('prof_id')->references('id')->on('users')->cascadeOnDelete();

            $table->integer('module_id')->nullable();
            $table->foreign('module_id')->references('id')->on('modules')->cascadeOnDelete();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();

            $table->boolean('toTeach_cm')->default(false); // Whether the professor wants to teach CM
            $table->boolean('toTeach_td')->default(false); // Whether the professor wants to teach TD
            $table->boolean('toTeach_tp')->default(false); // Whether the professor wants to teach TP
            $table->integer('hours')->nullable()->default(0); // Total hours requested by the professor



            $table->integer('action_by')->nullable();
            $table->foreign('action_by')->references('id')->on('users')->cascadeOnDelete();



            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prof_requests');
    }
};
