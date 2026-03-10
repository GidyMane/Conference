<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {

    public function up(): void
    {
        // Step 1: allow POWERPOINT temporarily
        DB::statement("
            ALTER TABLE submitted_abstracts 
            MODIFY presentation_preference ENUM('ORAL','POSTER','POWERPOINT') NULL
        ");

        // Step 2: convert old data
        DB::statement("
            UPDATE submitted_abstracts 
            SET presentation_preference = 'POWERPOINT'
            WHERE presentation_preference = 'ORAL'
        ");

        // Step 3: remove ORAL
        DB::statement("
            ALTER TABLE submitted_abstracts 
            MODIFY presentation_preference ENUM('POWERPOINT','POSTER') NULL
        ");
    }

    public function down(): void
    {
        // Step 1: allow ORAL again
        DB::statement("
            ALTER TABLE submitted_abstracts 
            MODIFY presentation_preference ENUM('ORAL','POSTER','POWERPOINT') NULL
        ");

        // Step 2: revert data
        DB::statement("
            UPDATE submitted_abstracts 
            SET presentation_preference = 'ORAL'
            WHERE presentation_preference = 'POWERPOINT'
        ");

        // Step 3: remove POWERPOINT
        DB::statement("
            ALTER TABLE submitted_abstracts 
            MODIFY presentation_preference ENUM('ORAL','POSTER') NULL
        ");
    }
};