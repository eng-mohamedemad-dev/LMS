<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // إضافة حقول للمدرسين
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->text('address')->nullable();
        });

        // إضافة حقول للطلاب
        Schema::table('students', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->text('address')->nullable();
        });

        // إضافة حقول لأولياء الأمور
        Schema::table('fathers', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->text('address')->nullable();
        });

        // إضافة حقول للمديرين
        Schema::table('admins', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->text('address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // حذف حقول من المدرسين
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['image', 'address']);
        });

        // حذف حقول من الطلاب
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['image', 'address']);
        });

        // حذف حقول من أولياء الأمور
        Schema::table('fathers', function (Blueprint $table) {
            $table->dropColumn(['image', 'address']);
        });

        // حذف حقول من المديرين
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['image', 'address']);
        });
    }
};
