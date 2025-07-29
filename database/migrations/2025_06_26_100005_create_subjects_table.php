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
Schema::create('subjects', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('name');
    $table->enum('classification', ['عام', 'رياضيات', 'أدبي', 'علمي','علوم'])->default('عام');
    $table->string('image')->nullable();
    $table->foreignid('classroom_id')->nullable()->constrained('classrooms')->nullOnDelete();
    $table->foreignUuid('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
