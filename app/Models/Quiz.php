<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'course_id',
        'chapter_id',
        'lesson_id',
        'title',
        'description',
        'duration',
        'attempts_allowed',
        'passing_score',
        'randomize_questions',
        'show_results',
        'status',
    ];

    // Casts
    protected $casts = [
        'randomize_questions' => 'boolean',
        'show_results' => 'boolean',
    ];

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
