<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FullPaper extends Model
{
    protected $fillable = [
        'submitted_abstract_id',
        'file_path',   // This is the main full paper
        'presentation_file_path', // optional
        'supplementary_files_path', // optional, could be JSON
        'file_type',
        'file_size',
        'status',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'supplementary_files_path' => 'array', // automatically decode JSON
    ];

    public function abstract()
    {
        return $this->belongsTo(SubmittedAbstract::class, 'submitted_abstract_id');
    }

    // Accessors for the URLs
    public function getPaperUrlAttribute()
    {
        return $this->file_path ? asset("storage/{$this->file_path}") : null;
    }

    public function getPresentationUrlAttribute()
    {
        return $this->presentation_file_path ? asset("storage/{$this->presentation_file_path}") : null;
    }

    public function getSupplementaryUrlsAttribute()
    {
        return $this->supplementary_files_path
            ? collect($this->supplementary_files_path)->map(fn($f) => asset("storage/{$f}"))->toArray()
            : [];
    }
}