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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('command');
            $table->string('argument')->nullable();
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('maid_id');
            $table->unsignedBigInteger('user_id');
            $table->enum("state",["wait_to_pick","delivered","reported"]);
            $table->timestamp('received_at')->nullable();
            $table->timestamp('reported_at')->nullable();
            $table->enum("report_type",["text","file","socket","failure"])->nullable();
            $table->string("report_message")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
