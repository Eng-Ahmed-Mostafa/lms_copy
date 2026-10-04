<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonProgress extends Model
{
    protected $table = 'lesson_progress';

    protected $fillable = [
        'enrollment_id',
        'lesson_id',
        'student_id',
        'progress_percentage',
        'watch_seconds',
        'completed',
        'completed_at',
        'last_position',
    ];

    // Cast
    protected $casts = [
        'progress_percentage' => 'decimal:2',
        'completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
