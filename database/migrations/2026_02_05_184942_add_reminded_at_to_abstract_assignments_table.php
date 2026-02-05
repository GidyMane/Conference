<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('abstract_assignments', function (Blueprint $table) {
            $table->timestamp('reminded_at')->nullable()->after('assigned_at');
        });
    }

    public function down(): void
    {
        Schema::table('abstract_assignments', function (Blueprint $table) {
            $table->dropColumn('reminded_at');
        });
    }
};