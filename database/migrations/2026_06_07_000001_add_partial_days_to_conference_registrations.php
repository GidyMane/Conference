<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('conference_registrations', function (Blueprint $table) {
            // 'full_week' = existing full-conference registration (default, backward compatible)
            // 'partial'   = new fewer-days registration
            $table->enum('attendance_type', ['full_week', 'partial'])->default('full_week')->after('platform');
            // Number of days (1–4) — only meaningful when attendance_type = 'partial'
            $table->unsignedTinyInteger('days_count')->nullable()->after('attendance_type');
        });
    }

    public function down(): void
    {
        Schema::table('conference_registrations', function (Blueprint $table) {
            $table->dropColumn(['attendance_type', 'days_count']);
        });
    }
};
