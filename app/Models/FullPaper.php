<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FullPaper extends Model
{
    protected $fillable = [
        'submitted_abstract_id',
        'file_path',
        'file_type',
        'file_size',
        'status',
        'uploaded_at',
    ];

    public function abstract()
    {
        return $this->belongsTo(SubmittedAbstract::class, 'submitted_abstract_id');
    }
}
