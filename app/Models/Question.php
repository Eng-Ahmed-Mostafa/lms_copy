<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'type',
        'question_text',
        'explanation',
        'points',
        'difficulty',
        'created_by',
        'status',
    ];

    // Casts
    protected $casts = [
        'points' => 'decimal:2',
    ];

    // Relationships
    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'quiz_questions')->withPivot('order', 'points');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attempts()
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_questions')->withPivot('order', 'points');
    }
}
