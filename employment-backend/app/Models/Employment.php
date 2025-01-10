<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'role',
        'job_grade',
        'employment_no',
        'employment_status',
        'manager',
        'join_date',
        'end_date',
    ];
}
