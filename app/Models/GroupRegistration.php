<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_prefix',
        'phone_number',
        'institution',
        'group_count',
        'total_fee',
        'currency',
        'transaction_id',
        'payment_proof_path', 
    ];

    public function members()
    {
        return $this->hasMany(GroupMember::class, 'group_registration_id'); // specify FK here too
    }
}


