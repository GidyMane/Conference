<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('full_paper_reviews', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | INDIVIDUAL CRITERION SCORES
            |--------------------------------------------------------------------------
            */

            // TITLE
            $table->unsignedTinyInteger('title_appropriate')->nullable();
            $table->unsignedTinyInteger('title_reflects_content')->nullable();

            // ABSTRACT
            $table->unsignedTinyInteger('abstract_word_count')->nullable();
            $table->unsignedTinyInteger('abstract_completeness')->nullable();

            // INTRODUCTION
            $table->unsignedTinyInteger('intro_background')->nullable();
            $table->unsignedTinyInteger('intro_originality')->nullable();
            $table->unsignedTinyInteger('intro_objectives')->nullable();

            // METHODS
            $table->unsignedTinyInteger('methods_replication')->nullable();
            $table->unsignedTinyInteger('methods_design')->nullable();
            $table->unsignedTinyInteger('methods_statistics')->nullable();
            $table->unsignedTinyInteger('methods_ethics')->nullable();

            // RESULTS
            $table->unsignedTinyInteger('results_insights')->nullable();
            $table->unsignedTinyInteger('results_narrative')->nullable();
            $table->unsignedTinyInteger('results_data_clarity')->nullable();
            $table->unsignedTinyInteger('results_visuals')->nullable();
            $table->unsignedTinyInteger('results_referencing')->nullable();

            // DISCUSSION
            $table->unsignedTinyInteger('discussion_context')->nullable();
            $table->unsignedTinyInteger('discussion_objectives')->nullable();
            $table->unsignedTinyInteger('discussion_significance')->nullable();
            $table->unsignedTinyInteger('discussion_theme')->nullable();
            $table->unsignedTinyInteger('discussion_references')->nullable();

            // CONCLUSION
            $table->unsignedTinyInteger('conclusion_objectives')->nullable();
            $table->unsignedTinyInteger('conclusion_consistency')->nullable();
            $table->unsignedTinyInteger('conclusion_contribution')->nullable();

            // REFERENCES
            $table->unsignedTinyInteger('acknowledgement_present')->nullable();
            $table->unsignedTinyInteger('references_accuracy')->nullable();
            $table->unsignedTinyInteger('references_balance')->nullable();
            $table->unsignedTinyInteger('references_citation')->nullable();
            $table->unsignedTinyInteger('references_matching')->nullable();


            /*
            |--------------------------------------------------------------------------
            | SECTION COMMENTS
            |--------------------------------------------------------------------------
            */

            $table->text('title_comments')->nullable();
            $table->text('abstract_comments')->nullable();
            $table->text('introduction_comments')->nullable();
            $table->text('methods_comments')->nullable();
            $table->text('results_comments')->nullable();
            $table->text('discussion_comments')->nullable();
            $table->text('conclusion_comments')->nullable();
            $table->text('references_comments')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('full_paper_reviews', function (Blueprint $table) {

            $table->dropColumn([
                'title_appropriate',
                'title_reflects_content',
                'abstract_word_count',
                'abstract_completeness',
                'intro_background',
                'intro_originality',
                'intro_objectives',
                'methods_replication',
                'methods_design',
                'methods_statistics',
                'methods_ethics',
                'results_insights',
                'results_narrative',
                'results_data_clarity',
                'results_visuals',
                'results_referencing',
                'discussion_context',
                'discussion_objectives',
                'discussion_significance',
                'discussion_theme',
                'discussion_references',
                'conclusion_objectives',
                'conclusion_consistency',
                'conclusion_contribution',
                'acknowledgement_present',
                'references_accuracy',
                'references_balance',
                'references_citation',
                'references_matching',

                'title_comments',
                'abstract_comments',
                'introduction_comments',
                'methods_comments',
                'results_comments',
                'discussion_comments',
                'conclusion_comments',
                'references_comments',
            ]);
        });
    }

};
