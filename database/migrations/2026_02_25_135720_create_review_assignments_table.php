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
        Schema::create('review_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('full_paper_id')->constrained()->cascadeOnDelete();
            $table->foreignId('prequalified_reviewer_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('peer_reviewer_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->enum('type', ['prequalified', 'peer']);
            $table->enum('status', ['pending', 'started', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_assignments');
    }
};
