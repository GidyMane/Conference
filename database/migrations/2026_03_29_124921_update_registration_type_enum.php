<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    // STEP 1: Expand ENUM to allow BOTH old + new values
    DB::statement("
        ALTER TABLE exhibition_registrations 
        MODIFY registration_type ENUM(
            'with_meals', 
            'without_meals', 
            'standard', 
            'own_tent'
        ) NOT NULL
    ");

    // STEP 2: Convert old values → new values
    DB::statement("
        UPDATE exhibition_registrations 
        SET registration_type = 'standard' 
        WHERE registration_type = 'with_meals'
    ");

    DB::statement("
        UPDATE exhibition_registrations 
        SET registration_type = 'own_tent' 
        WHERE registration_type = 'without_meals'
    ");

    // STEP 3: Drop old ENUM values
    DB::statement("
        ALTER TABLE exhibition_registrations 
        MODIFY registration_type ENUM(
            'standard', 
            'own_tent'
        ) NOT NULL
    ");
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
