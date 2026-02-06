<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reviewer extends Model
{
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subThemes()
    {
        return $this->belongsToMany(SubTheme::class, 'reviewer_sub_theme');
    }

    public function assignments()
    {
        return $this->hasMany(AbstractAssignment::class);
    }
}
