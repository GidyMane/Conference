<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'full_name',
        'email',
        'password',
        'role',
        'is_active',
        'password_setup_token',
        'password_setup_expires_at',
    ];

    protected $hidden = [
        'password',
        'password_setup_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'password_setup_expires_at' => 'datetime',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'ADMIN';
    }

    public function isReviewer(): bool
    {
        return $this->role === 'REVIEWER';
    }

    public function reviewer()
    {
        return $this->hasOne(Reviewer::class);
    }

    public function assignedAbstracts()
    {
        return $this->hasMany(AbstractAssignment::class, 'reviewer_id');
    }

    public function reviews()
    {
        return $this->hasMany(AbstractReview::class, 'reviewer_id');
    }
}
