<?php

use App\Models\Product;
use App\Models\User;
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
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
            $table->integer('licenses');
            $table->string('os');
            $table->dateTime('date');
            $table->float('distance', 8, 2);
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('note')->nullable();
            $table->float('price', 8, 2);
            $table->string('payment_by');
            $table->enum('status', ['installed', 'in_progress', 'canceled'])->default('in_progress');
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
