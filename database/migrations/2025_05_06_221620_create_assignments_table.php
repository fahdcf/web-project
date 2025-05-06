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
            $table->integer('module_id')->index('module_id');
            $table->integer('professor_id')->index('professor_id');
            $table->integer('hours');
            $table->enum('status', ['assigned', 'pending', 'declined'])->nullable()->default('pending');
            $table->enum('semester', ['fall', 'spring', 'summer']);
            $table->integer('year');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
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
