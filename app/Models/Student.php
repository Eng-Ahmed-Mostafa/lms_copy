<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'student_number',
        'grade_id',
        'classroom_id',
        'academic_year_id',
        'enrollment_date',
        'status',
    ];

    // Casts
    protected $casts = [
        'enrollment_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_student', 'student_id', 'classroom_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function guardians()
    {
        return $this->belongsToMany(Guardian::class, 'guardian_student')
                    ->withPivot('relationship', 'is_primary', 'can_view_grades', 'can_view_attendance', 'can_view_payments', 'can_receive_notifications')
                    ->withTimestamps();
    }
}
