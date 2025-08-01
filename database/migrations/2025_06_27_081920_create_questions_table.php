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
Schema::create('questions', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->text('question_text');
    $table->json('options');
    $table->string('correct_answer');
    $table->foreignUuid('quiz_id')->constrained('quizzes')->cascadeOnDelete();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
