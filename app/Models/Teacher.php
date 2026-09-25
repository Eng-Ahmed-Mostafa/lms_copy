<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'employee_number',
        'bio',
        'qualification',
        'specialization',
        'experience_years',
        'hire_date',
        'status',
    ];

    // Casts
    protected $casts = [
        'hire_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher', 'teacher_id', 'subject_id')
                    ->withTimestamps();
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_teacher', 'teacher_id', 'student_id')
                    ->withTimestamps();
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
