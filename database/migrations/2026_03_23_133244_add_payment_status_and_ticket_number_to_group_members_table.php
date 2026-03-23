<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('group_members', function (Blueprint $table) {
            if (!Schema::hasColumn('group_members', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'approved', 'rejected'])
                      ->default('pending')
                      ->after('fee');
            }

            if (!Schema::hasColumn('group_members', 'ticket_number')) {
                $table->string('ticket_number')->nullable()->after('payment_status');
            }

            if (!Schema::hasColumn('group_members', 'verified_by')) {
                $table->unsignedBigInteger('verified_by')->nullable()->after('ticket_number');
            }

            if (!Schema::hasColumn('group_members', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('group_members', function (Blueprint $table) {
            if (Schema::hasColumn('group_members', 'payment_status')) {
                $table->dropColumn('payment_status');
            }

            if (Schema::hasColumn('group_members', 'ticket_number')) {
                $table->dropColumn('ticket_number');
            }

            if (Schema::hasColumn('group_members', 'verified_by')) {
                $table->dropColumn('verified_by');
            }

            if (Schema::hasColumn('group_members', 'verified_at')) {
                $table->dropColumn('verified_at');
            }
        });
    }
};