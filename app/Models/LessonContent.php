<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonContent extends Model
{
    protected $fillable = [
        'lesson_version_id',
        'type',
        'content',
        'file_path',
        'video_url',
        'duration',
        'order',
        'metadata',
    ];

    // Cast
    protected $casts = [
        'metadata' => 'array',
    ];

    // Relationships
    public function lessonVersion()
    {
        return $this->belongsTo(LessonVersion::class);
    }
}
