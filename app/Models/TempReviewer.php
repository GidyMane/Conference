<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempReviewer extends Model
{
    protected $fillable = [
        'user_id',
        'sub_theme_id',
        'expires_at'
    ];

    protected $casts = [
    'expires_at' => 'datetime',
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
