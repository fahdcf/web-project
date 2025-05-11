<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLogsTable extends Migration
{
    public function up(): void
    {
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('action');                      // Action description
            $table->string('ip_address')->nullable();      // Optional: log IP
            $table->text('user_agent')->nullable();        // Optional: browser info
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_logs');
    }
}
