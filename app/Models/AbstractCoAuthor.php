<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AbstractCoAuthor extends Model
{
    use HasFactory;

    protected $table = 'abstract_co_authors';

    protected $fillable = [
        'abstract_id',
        'full_name',
        'institution',
        'author_order',
    ];

    public function abstract()
    {
        return $this->belongsTo(SubmittedAbstract::class, 'abstract_id');
    }
}
