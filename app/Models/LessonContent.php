<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class LessonContent extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'lesson_contents';

    protected $fillable = [
        'lesson_version_id',
        'type',
        'content',
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

    // Media Library
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('lesson_files')->singleFile();

        $this->addMediaCollection('lesson_videos')->singleFile();
    }
}
