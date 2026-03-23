<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('conference_registrations', function (Blueprint $table) {
            $table->string('paper_ref_code')->nullable()->after('category');
        });
    }

    public function down()
    {
        Schema::table('conference_registrations', function (Blueprint $table) {
            $table->dropColumn('paper_ref_code');
        });
    }
};
