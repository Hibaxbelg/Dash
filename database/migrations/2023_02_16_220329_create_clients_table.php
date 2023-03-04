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
        Schema::create('mainmedlist', function (Blueprint $table) {
            $table->id();
            $table->string('FAMNAME');
            $table->string('SHORTNAME');
            $table->string('SPECIALITE');
            $table->string('SHORTNAME');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mainmedlist');
    }
};
