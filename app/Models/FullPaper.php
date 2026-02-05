<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FullPaper extends Model
{
    protected $fillable = [
        'submitted_abstract_id',
        'file_path',
        'presentation_file_path',
        'supplementary_files_path',
        'file_type',
        'file_size',
        'status',
        'uploaded_at',
        'full_paper_code', // IMPORTANT
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'supplementary_files_path' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($fullPaper) {

            $abstract = $fullPaper->abstract;

            if (!$abstract || !$abstract->abstract_code) {
                return;
            }

            // Example: generate FP_002
            $nextNumber = self::where('submitted_abstract_id', $abstract->id)->count() + 1;
            $fullPaperCode = 'FP_' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            $fullPaper->full_paper_code = $fullPaperCode;

            // Rename the main file
            if ($fullPaper->file_path) {
                $extension = pathinfo($fullPaper->file_path, PATHINFO_EXTENSION);

                $newFileName = "{$abstract->abstract_code}-{$fullPaperCode}.{$extension}";
                $newPath = "full_papers/{$newFileName}";

                Storage::disk('public')->move($fullPaper->file_path, $newPath);

                $fullPaper->file_path = $newPath;
            }
        });
    }

    public function abstract()
    {
        return $this->belongsTo(SubmittedAbstract::class, 'submitted_abstract_id');
    }

    // URLs
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
            ? collect($this->supplementary_files_path)
                ->map(fn ($f) => asset("storage/{$f}"))
                ->toArray()
            : [];
    }
}