<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exhibition_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('reference_number')->unique();
            
            // Organization Information
            $table->string('organization_name');
            $table->text('about_exhibition');
            $table->text('benefits');
            
            // Booth Details
            $table->integer('booth_count')->default(1);
            $table->enum('registration_type', ['with_meals', 'without_meals']);
            $table->decimal('total_amount', 10, 2);
            
            // Payment Information
            $table->enum('payment_method', ['bank', 'mpesa']);
            $table->string('receipt_number');
            $table->string('payment_proof_path')->nullable();
            $table->enum('payment_status', ['pending', 'verified', 'failed'])->default('pending');
            
            // Contact Information
            $table->string('contact_name');
            $table->string('contact_role');
            $table->string('contact_phone');
            $table->string('contact_email');
            $table->boolean('is_team_leader')->default(false);
            $table->integer('team_size')->default(1);
            
            // Admin Fields
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            
            // Booth Allocation
            $table->string('booth_number')->nullable();
            $table->text('special_requests')->nullable();
            
            // Email Tracking
            $table->timestamp('confirmation_email_sent_at')->nullable();
            $table->timestamp('approval_email_sent_at')->nullable();
            
            $table->timestamps();
            
            // Foreign Keys
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            
            // Indexes for performance
            $table->index('status');
            $table->index('payment_status');
            $table->index('reference_number');
            $table->index('contact_email');
        });
    }

    public function down()
    {
        Schema::dropIfExists('exhibition_registrations');
    }
};
