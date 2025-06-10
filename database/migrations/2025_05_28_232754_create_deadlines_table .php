<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{
   public function up()
    {
        Schema::create('deadlines', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['note', 'ue_selecion'])->index();
            
            $table->dateTime('deadline_date'); // Configuration due date

            $table->dateTime('notification_date'); // Start sending notifications

            $table->enum('status', ['active', 'expired'])->default('active');


            $table->integer('created_by')->nullable();//who set the desad line
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnDelete();


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deadlines');
    }
};