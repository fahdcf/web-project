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
        Schema::create('chef_actions', function (Blueprint $table) {
            $table->id();
            $table->integer('chef_id');           // Chef user
            $table->string('action_type');                   // e.g., "recipe_created", "menu_updated"
            $table->text('description');                      // Detailed action description
            $table->string('target_table')->nullable();       // e.g., "recipes", "menus"
            $table->unsignedBigInteger('target_id')->nullable(); // ID of the affected record
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('chef_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            
            // Optional: Index for better performance on frequent queries
            $table->index(['chef_id', 'action_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chef_actions');
    }
};