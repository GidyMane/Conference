<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubTheme extends Model
{
    use HasFactory;

    protected $table = 'sub_themes';

    protected $fillable = [
        'form_field_value',
        'full_name',
        'code',
    ];

    public function reviewers()
    {
        return $this->hasMany(Reviewer::class);
    }
}
