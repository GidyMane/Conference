<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrequalifiedReviewer extends Model
{
    protected $fillable = [
        'name',
        'title',
        'email',
        'phone',
        'institution',
        'area_of_specialization',
        'sub_theme_id',
    ];

    public function subTheme()
    {
        return $this->belongsTo(SubTheme::class, 'sub_theme_id');
    }

    public function assignments()
    {
        return $this->hasMany(ReviewAssignment::class, 'prequalified_reviewer_id');
    }
}