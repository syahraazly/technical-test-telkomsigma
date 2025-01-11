<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employment extends Model
{
    use HasFactory;

    // enum untuk employment_status
    const EMPLOYMENT_STATUS_CONTRACT = 'Contract';
    const EMPLOYMENT_STATUS_PERMANENT = 'Permanent';
    const EMPLOYMENT_STATUS_PROBATION = 'Probation';

    // enum untuk job_grade
    const JOB_GRADE_JUNIOR = 'Junior';
    const JOB_GRADE_MIDDLE = 'Middle';
    const JOB_GRADE_SENIOR = 'Senior';

    // enum untuk gender
    const GENDER_MALE = 'Male';
    const GENDER_FEMALE = 'Female';

    protected $fillable = [
        'name',
        'gender',
        'role',
        'job_grade',
        'employment_no',
        'employment_status',
        'manager',
        'join_date',
        'end_date'
    ];

    // validasi enum
    public static $employmentStatusEnum = [
        self::EMPLOYMENT_STATUS_CONTRACT,
        self::EMPLOYMENT_STATUS_PERMANENT,
        self::EMPLOYMENT_STATUS_PROBATION
    ];

    public static $jobGradeEnum = [
        self::JOB_GRADE_JUNIOR,
        self::JOB_GRADE_MIDDLE,
        self::JOB_GRADE_SENIOR
    ];

    public static $genderEnum = [
        self::GENDER_MALE,
        self::GENDER_FEMALE
    ];
}
