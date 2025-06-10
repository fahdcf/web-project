<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{
    public function up()
    {
        Schema::create('user_logs', function (Blueprint $table) {
            $table->id();

            $table->integer('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->nullable();

            $table->string('action');
            $table->string('ip_addres')->nullable(); // note: typo kept as per your code (see below)
            $table->string('user_agent')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('user_logs');
    }
};

