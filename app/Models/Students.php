<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_no',
        'fname',
        'mname',
        'lname',
        'gender',
        'mobile',
        'birthdate',
        'email',
        'course',
        'year',
        'section',
        'address',
        'profile_picture',
        'status',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id_no', 'id_no');
    }
}
