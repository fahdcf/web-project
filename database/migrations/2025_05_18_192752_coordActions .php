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
        Schema::create('coord_actions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');           // User ID
            $table->string('action_type');
            $table->string('target_table')->in(['modules', 'assignments', 'emplois', 'seances']);
            $table->unsignedBigInteger('target_id')->nullable();
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coord_actions');
    }
};
