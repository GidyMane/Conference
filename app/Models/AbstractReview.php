<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbstractReview extends Model
{
    use HasFactory;

    protected $table = 'abstract_reviews';

    protected $fillable = [
        'abstract_id',
        'reviewer_id',
        'comment',
        'decision',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function abstract()
    {
        return $this->belongsTo(SubmittedAbstract::class, 'abstract_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
