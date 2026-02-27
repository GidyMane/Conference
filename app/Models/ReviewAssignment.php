<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewAssignment extends Model
{
    protected $fillable = [
        'full_paper_id',
        'prequalified_reviewer_id',
        'peer_reviewer_id',
        'type',
        'status',
        'review_token', 
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Full Paper
    public function fullPaper()
    {
        return $this->belongsTo(FullPaper::class);
    }

    // Prequalified Reviewer
    public function prequalifiedReviewer()
    {
        return $this->belongsTo(PrequalifiedReviewer::class, 'prequalified_reviewer_id');
    }

    // Peer Reviewer (User model)
    public function peerReviewer()
    {
        return $this->belongsTo(User::class, 'peer_reviewer_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Scopes (Optional but Useful)
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'started']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePrequalified($query)
    {
        return $query->where('type', 'prequalified');
    }

    public function scopePeer($query)
    {
        return $query->where('type', 'peer');
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    public function isPrequalified(): bool
    {
        return $this->type === 'prequalified';
    }

    public function isPeer(): bool
    {
        return $this->type === 'peer';
    }

    public function paper()
    {
        return $this->belongsTo(FullPaper::class, 'full_paper_id');
    }
}
