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
        Schema::table('vacataires', function (Blueprint $table) {
            $table->foreign(['user_id'], 'vacataires_ibfk_1')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['module_id'], 'vacataires_ibfk_2')->references(['id'])->on('modules')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vacataires', function (Blueprint $table) {
            $table->dropForeign('vacataires_ibfk_1');
            $table->dropForeign('vacataires_ibfk_2');
        });
    }
};
