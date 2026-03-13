<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresentationUpload extends Model
{
    protected $fillable = [
        'full_paper_id',
        'powerpoint_file',
        'poster_file',
        'supporting_documents',
        'revised_fullpaper',
        'uploaded_at'
    ];

    protected $casts = [
        'supporting_documents' => 'array'
    ];

    public function fullPaper()
    {
        return $this->belongsTo(FullPaper::class);
    }
}