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
        Schema::create('fathers', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->string('name');
        $table->string('phone')->unique();
        $table->string('email')->unique();
        $table->string('password');
        $table->enum('status', ['pending', 'approved'])->default('pending');
        $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fathers');
    }
};
