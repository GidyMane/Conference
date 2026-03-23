<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_registration_id', // links to GroupRegistration
        'first_name',
        'last_name',
        'email',
        'institution',
        'nationality',
        'platform',
        'category',
        'presenter',
        'paper_ref_code',
        'student_id',
        'fee',
        'currency',
        'payment_status',
        'ticket_number',   
        'verified_by',    
        'verified_at'  
    ];

    // Relationship to the group
    public function group()
    {
        return $this->belongsTo(GroupRegistration::class, 'group_registration_id'); // specify the FK
    }
}