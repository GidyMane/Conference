<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE submitted_abstracts 
            MODIFY status ENUM(
                'PENDING',
                'UNDER_REVIEW',
                'APPROVED',
                'REJECTED',
                'RESUBMIT'
            ) DEFAULT 'PENDING'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE submitted_abstracts 
            MODIFY status ENUM(
                'PENDING',
                'UNDER_REVIEW',
                'APPROVED',
                'REJECTED'
            ) DEFAULT 'PENDING'
        ");
    }
};
