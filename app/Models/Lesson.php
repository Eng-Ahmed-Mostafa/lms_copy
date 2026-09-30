<?php

namespace App\Models;

use App\Observers\SlugObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

#[ObservedBy(SlugObserver::class)]
class Lesson extends Model
{
    use Searchable;

    protected $fillable = [
        'chapter_id',
        'title',
        'description',
        'duration',
        'order',
        'is_free',
        'status',
        'approval_status',
        'published_at',
    ];

    // Casts
    protected $casts = [
        'is_free' => 'boolean',
        'published_at' => 'datetime',
    ];

    // Searchable
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'chapter_id' => $this->chapter_id,
            'title' => $this->title,
            'description' => $this->description,
            'duration' => $this->duration,
            'order' => $this->order,
            'is_free' => $this->is_free,
            'status' => $this->status,
            'approval_status' => $this->approval_status,
            'published_at' => $this->published_at ? $this->published_at->toDateTimeString() : null,
        ];
    }

    // Relationships
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function versions()
    {
        return $this->hasMany(LessonVersion::class);
    }
}
