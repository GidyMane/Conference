<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('abstract_reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('abstract_id')
                ->constrained('submitted_abstracts')
                ->cascadeOnDelete();

            $table->foreignId('reviewer_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->text('comment')->nullable();

            $table->enum('decision', ['APPROVED', 'REJECTED'])->nullable();

            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();

            $table->unique(['abstract_id', 'reviewer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abstract_reviews');
    }
};
