<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reviewer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sub_theme_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subTheme()
    {
        return $this->belongsTo(SubTheme::class);
    }
}
