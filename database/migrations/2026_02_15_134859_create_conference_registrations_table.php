<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('conference_registrations', function (Blueprint $table) {
            $table->id();

            // Personal Details
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->index();
            $table->string('phone_prefix');
            $table->string('phone_number');
            $table->string('institution');
            $table->string('country');
            $table->enum('nationality', ['east_african', 'non_east_african']);

            // Registration Details
            $table->enum('platform', ['physical', 'virtual']);
            $table->enum('category', ['student', 'professional', 'kalro_staff']);

            $table->string('student_id_path')->nullable();

            // Fee
            $table->decimal('fee', 10, 2);
            $table->string('fee_currency');

            // Payment
            $table->enum('payment_method', ['bank', 'mpesa']);
            $table->string('transaction_id');
            $table->string('payment_proof_path');

            // Admin Verification
            $table->enum('payment_status', ['pending', 'approved', 'rejected'])
                  ->default('pending');

            $table->text('rejection_reason')->nullable();

            // Ticket
            $table->string('ticket_number')->nullable()->unique();

            // Verified by Admin
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conference_registrations');
    }
};