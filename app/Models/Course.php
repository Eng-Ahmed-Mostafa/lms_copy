<?php

namespace App\Models;

use App\Observers\SlugObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(SlugObserver::class)]
class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'teacher_id',
        'course_category_id',
        'subject_id',
        'title',
        'slug',
        'short_description',
        'description',
        'thumbnail',
        'preview_video',
        'price',
        'discount_price',
        'duration',
        'level',
        'language',
        'status',
        'approval_status',
        'published_at'
    ];

    // Casts
    protected $casts = [
        'published_at' => 'datetime',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'duration' => 'integer',
    ];

    // Accessors
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Relationships
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function courseCategory()
    {
        return $this->belongsTo(CourseCategory::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
