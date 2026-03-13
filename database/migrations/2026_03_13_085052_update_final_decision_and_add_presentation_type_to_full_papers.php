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
        Schema::table('full_papers', function (Blueprint $table) {

            $table->enum('final_decision', [
                'approved',
                'not_approved',
                'approved_with_minor_revisions',
                'approved_with_major_revisions'
            ])->nullable()->change();

            $table->enum('presentation_type', [
                'powerpoint',
                'poster'
            ])->nullable()->after('final_decision');

        });
    }

    public function down(): void
    {
        Schema::table('full_papers', function (Blueprint $table) {

            $table->enum('final_decision', [
                'approved',
                'rejected'
            ])->nullable()->change();

            $table->dropColumn('presentation_type');
        });
    }
};
