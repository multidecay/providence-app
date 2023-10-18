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
        Schema::create('codegen_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('codegen_id');
            $table->unsignedBigInteger('user_id');
            $table->string("filename")->unique();
            $table->text("content");
            $table->timestamps();
            
            $table->foreign('codegen_id')->references('id')->on('codegens');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codegen_files');
    }
};
