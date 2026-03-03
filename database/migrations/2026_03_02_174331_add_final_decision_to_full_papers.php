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
            $table->enum('final_decision', ['approved', 'rejected'])->nullable();
            $table->text('leader_comments')->nullable();
            $table->timestamp('decision_made_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('full_papers', function (Blueprint $table) {
            //
        });
    }
};
