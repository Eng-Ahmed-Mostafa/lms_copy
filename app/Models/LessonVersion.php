<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonVersion extends Model
{
    protected $fillable = [
        'lesson_id',
        'version_number',
        'title',
        'description',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
        'published_at',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
