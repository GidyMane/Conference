<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateConferenceRegistrationsTable extends Migration
{
    public function up()
    {
        Schema::table('conference_registrations', function (Blueprint $table) {
            if (!Schema::hasColumn('conference_registrations', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('payment_proof_path');
            }
            if (!Schema::hasColumn('conference_registrations', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('conference_registrations', 'ticket_number')) {
                $table->string('ticket_number')->unique()->nullable()->after('rejection_reason');
            }
            if (!Schema::hasColumn('conference_registrations', 'verified_by')) {
                $table->foreignId('verified_by')->nullable()->constrained('users')->after('ticket_number');
            }
            if (!Schema::hasColumn('conference_registrations', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }
        });
    }

    public function down()
    {
        Schema::table('conference_registrations', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'rejection_reason',
                'ticket_number',
                'verified_by',
                'verified_at'
            ]);
        });
    }
}