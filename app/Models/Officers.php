<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officers extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_no',
        'fname',
        'mname',
        'lname',
        'gender',
        'mobile',
        'birthdate',
        'position',
        'email',
        'address',
        'profile_picture',
        'status',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id_no', 'id_no');
    }
}

