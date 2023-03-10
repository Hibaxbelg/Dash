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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->dateTime('date');
            $table->enum('status', ['installed', 'in_progress', 'canceled'])->default('in_progress');
            $table->string('note')->nullable();
            $table->integer('posts')->default(1);
            $table->timestamps();

            // $table->foreign('doctor_id')->references('RECORD_ID')->on('doctors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commands');
    }
};
