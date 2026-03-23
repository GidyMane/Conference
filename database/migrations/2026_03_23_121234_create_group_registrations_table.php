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
        Schema::create('group_registrations', function (Blueprint $table) {
            $table->id();

            // Coordinator
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone_prefix');
            $table->string('phone_number');
            $table->string('institution');

            // Group info
            $table->integer('group_count');

            // Payment
            $table->decimal('total_fee', 10, 2);
            $table->string('currency');

            $table->enum('payment_method', ['bank', 'mpesa']);
            $table->string('transaction_id');
            $table->string('payment_proof_path');

            $table->enum('payment_status', ['pending', 'approved', 'rejected'])
                ->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_registrations');
    }
};
