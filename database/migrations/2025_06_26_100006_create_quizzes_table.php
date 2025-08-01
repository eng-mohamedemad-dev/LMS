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
Schema::create('quizzes', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('title');
    $table->foreignUuid('subject_id')->constrained('subjects')->cascadeOnDelete();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
