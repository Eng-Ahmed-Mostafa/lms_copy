<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseProgress extends Model
{
    protected $table = 'course_progress';

    protected $fillable = [
        'enrollment_id',
        'course_id',
        'student_id',
        'progress_percentage',
        'completed_lessons',
        'total_lessons',
        'completed',
        'completed_at',
    ];

    // Casts
    protected $casts = [
        'progress_percentage' => 'decimal:2',
        'completed_lessons' => 'integer',
        'total_lessons' => 'integer',
        'completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
