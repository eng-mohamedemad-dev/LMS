<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        // تغيير نوع العمود إلى CHAR(36) لتخزين UUID
        DB::statement('ALTER TABLE notifications MODIFY notifiable_id CHAR(36)');
    }

    public function down(): void
    {
        // رجوع لنوع BIGINT UNSIGNED لو كان ده النوع القديم
        DB::statement('ALTER TABLE notifications MODIFY notifiable_id BIGINT UNSIGNED');
    }
};
