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
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('user_id');
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            
            $table->boolean('isadmin')->nullable()->default(false);
            $table->boolean('iscoordonnateur')->nullable()->default(false);
            $table->boolean('ischef')->nullable()->default(false);
            $table->boolean('isprof')->nullable()->default(false);
            $table->boolean('isvocataire')->nullable()->default(false);
            $table->boolean('isstudent')->nullable()->default(false);
            
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
