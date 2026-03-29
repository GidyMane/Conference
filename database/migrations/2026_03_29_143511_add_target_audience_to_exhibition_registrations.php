<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('exhibition_registrations', function (Blueprint $table) {
            $table->text('target_audience')->after('booth_count');
        });
    }

    public function down()
    {
        Schema::table('exhibition_registrations', function (Blueprint $table) {
            $table->dropColumn('target_audience');
        });
    }
};
