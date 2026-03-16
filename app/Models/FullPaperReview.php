<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FullPaperReview extends Model
{
    protected $fillable = [

        'review_assignment_id',

        /*
        |--------------------------------------------------------------------------
        | SECTION TOTAL SCORES
        |--------------------------------------------------------------------------
        */

        'score_title',
        'score_abstract',
        'score_introduction',
        'score_methods',
        'score_results',
        'score_discussion',
        'score_conclusion',
        'score_references',

        /*
        |--------------------------------------------------------------------------
        | INDIVIDUAL CRITERIA
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | COMMENTS
        |--------------------------------------------------------------------------
        */

        'title_comments',
        'abstract_comments',
        'introduction_comments',
        'methods_comments',
        'results_comments',
        'discussion_comments',
        'conclusion_comments',
        'references_comments',

        'overall_comments',

        'recommendation',
        'presentation_type',
        'total_score',
        'submitted_at'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function assignment()
    {
        return $this->belongsTo(ReviewAssignment::class, 'review_assignment_id');
    }
}