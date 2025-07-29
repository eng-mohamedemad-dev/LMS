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
       Schema::create('favorite_lessons', function (Blueprint $table) {
        $table->id();
        $table->foreignUuid('student_id')->constrained('students')->cascadeOnDelete();
        $table->foreignUuid('lesson_id')->constrained('lessons')->cascadeOnDelete();
        $table->timestamps();
        $table->unique(['student_id', 'lesson_id']); 
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_lessons');
    }
};
