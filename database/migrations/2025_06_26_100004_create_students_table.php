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
Schema::create('students', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->string('father_phone');
    $table->enum('classification', ['عام','علمي','رياضيات','أدبي','علوم'])->default('عام');
    $table->enum('status', ['pending', 'approved'])->default('pending');
    $table->foreignUuid('father_id')->nullable()->constrained('fathers')->nullOnDelete();
    $table->foreignid('classroom_id')->constrained('classrooms')->cascadeOnDelete();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
