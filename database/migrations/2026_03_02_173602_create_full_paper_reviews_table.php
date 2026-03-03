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
        Schema::create('full_paper_reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('review_assignment_id')
                ->constrained()
                ->cascadeOnDelete();

            // SECTION SCORES (8 sections – KALRO template)
            $table->unsignedTinyInteger('score_title')->nullable();
            $table->unsignedTinyInteger('score_abstract')->nullable();
            $table->unsignedTinyInteger('score_introduction')->nullable();
            $table->unsignedTinyInteger('score_methods')->nullable();
            $table->unsignedTinyInteger('score_results')->nullable();
            $table->unsignedTinyInteger('score_discussion')->nullable();
            $table->unsignedTinyInteger('score_conclusion')->nullable();
            $table->unsignedTinyInteger('score_references')->nullable();

            // TOTAL SCORE
            $table->unsignedTinyInteger('total_score')->nullable();

            // Recommendation
            $table->enum('recommendation', [
                'accept',
                'needs_minor_revisions',
                'needs_major_revisions',
                'reject'
            ]);

            // Presentation Type
            $table->string('presentation_type')->nullable();

            // Comments
            $table->text('overall_comments')->nullable();

            $table->timestamp('submitted_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('full_paper_reviews');
    }
};
