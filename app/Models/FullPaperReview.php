<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FullPaperReview extends Model
{
    protected $fillable = [
        'review_assignment_id',
        'score_title',
        'score_abstract',
        'score_introduction',
        'score_methods',
        'score_results',
        'score_discussion',
        'score_conclusion',
        'score_references',
        'total_score',
        'recommendation',
        'presentation_type',
        'overall_comments',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function assignment()
    {
        return $this->belongsTo(ReviewAssignment::class, 'review_assignment_id');
    }
}