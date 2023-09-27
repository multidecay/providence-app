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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('hwid')->unique();
            $table->string('operating_system');
            $table->unsignedBigInteger('maid_id');
            $table->string('country_code');
            $table->string('hostname')->nullable();
            $table->ipAddress('ip');
            $table->string('notes');
            $table->json('abilities');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('maid_id')->references('id')->on('maids');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
