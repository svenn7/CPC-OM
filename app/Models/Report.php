<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'violation_id',
        'officer_id',
        'offense'
    ];

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id');
    }

    public function violation()
    {
        return $this->belongsTo(Violation::class, 'violation_id');
    }

    public function officer()
    {
        return $this->belongsTo(Officers::class, 'officer_id');
    }
}
