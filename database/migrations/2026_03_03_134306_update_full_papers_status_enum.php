<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('full_papers', function (Blueprint $table) {
            // Add both UNDER_REVIEW and AWAITING_DECISION
            $table->enum('status', ['PENDING', 'UNDER_REVIEW', 'AWAITING_DECISION', 'APPROVED', 'REJECTED'])
                ->default('PENDING')
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('full_papers', function (Blueprint $table) {
            // Revert back to original ENUM without the two new statuses
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED'])
                ->default('PENDING')
                ->change();
        });
    }
};