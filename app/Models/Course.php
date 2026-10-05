<?php

namespace App\Models;

use App\Observers\SlugObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy(SlugObserver::class)]
class Course extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Searchable;

    protected $fillable = [
        'teacher_id',
        'course_category_id',
        'subject_id',
        'title',
        'slug',
        'short_description',
        'description',
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

    // Searchable
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'duration' => $this->duration,
            'level' => $this->level,
            'language' => $this->language,
        ];
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

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_student')->withTimestamps();
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Chapter::class);
    }

    public function quizzes()
    {
        return $this->hasManyThrough(Quiz::class, Chapter::class);
    }

    // Media Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('course_thumbnail')->singleFile();
        $this->addMediaCollection('course_preview_video')->singleFile();
    }
}
