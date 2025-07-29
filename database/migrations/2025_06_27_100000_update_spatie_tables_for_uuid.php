<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // تعديل model_id في جدول model_has_roles
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->char('model_id', 36)->change();
        });
        // تعديل model_id في جدول model_has_permissions
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->char('model_id', 36)->change();
        });
    }

    public function down(): void
    {
        // إعادة model_id إلى int (لو احتجت ترجع)
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('model_id')->change();
        });
        Schema::table('model_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('model_id')->change();
        });
    }
};
