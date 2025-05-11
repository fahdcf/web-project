<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminActionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('admin_actions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->string('action_type');                   // e.g., "module_added"
            $table->text('description');                     // Detailed info
            $table->string('target_table')->nullable();      // e.g., "users", "modules"
            $table->unsignedBigInteger('target_id')->nullable(); // ID of the affected record
            $table->timestamps();

            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_actions');
    }
}
