<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubmittedAbstract extends Model
{
    use HasFactory;

    protected $table = 'submitted_abstracts';

    protected $fillable = [
        'submission_code',
        'author_name',
        'author_email',
        'author_phone',
        'organisation',
        'department',
        'position',
        'sub_theme_id',
        'paper_title',
        'abstract_text',
        'keywords',
        'presentation_preference',
        'attendance_mode',
        'special_requirements',
        'status',
    ];

    public function subTheme()
    {
        return $this->belongsTo(SubTheme::class);
    }

    public static function generateSubmissionCode($subThemeId)
    {
        $subTheme = SubTheme::findOrFail($subThemeId);

        $count = self::where('sub_theme_id', $subThemeId)->count() + 1;

        $number = str_pad($count, 3, '0', STR_PAD_LEFT);

        return "KALROCONF_SUB{$subTheme->code}_{$number}";
    }

    public function coAuthors()
    {
        return $this->hasMany(AbstractCoAuthor::class, 'abstract_id')->orderBy('author_order');
    }

    public function assignments()
    {
        return $this->hasMany(AbstractAssignment::class, 'abstract_id');
    }

    public function reviewers()
    {
        return $this->belongsToMany(User::class, 'abstract_assignments', 'abstract_id', 'reviewer_id');
    }

    public function reviews()
    {
        return $this->hasMany(AbstractReview::class, 'abstract_id');
    }
}
