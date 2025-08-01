<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('email_verification_codes', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('user_type'); // admin, teacher, student, father
            $table->string('code', 6)->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('email_verify_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_verification_codes');
    }
};
