<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('presentation_uploads', function (Blueprint $table) {
            // Add revised full paper upload column
            $table->string('revised_fullpaper')->nullable()->after('full_paper_id');
        });
    }

    public function down(): void
    {
        Schema::table('presentation_uploads', function (Blueprint $table) {
            $table->dropColumn('revised_fullpaper');
        });
    }
};