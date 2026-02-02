<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbstractAssignment extends Model
{
    use HasFactory;

    protected $table = 'abstract_assignments';

    protected $fillable = [
        'abstract_id',
        'reviewer_id',
        'assigned_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
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
