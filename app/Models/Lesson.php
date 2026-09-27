<?php

namespace App\Models;

use App\Observers\SlugObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(SlugObserver::class)]
class Lesson extends Model
{
    protected $fillable = [
        'chapter_id',
        'title',
        'description',
        'type',
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


    // Relationships
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
