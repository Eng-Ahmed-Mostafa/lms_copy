<?php

namespace App\Models;

use App\Observers\SlugObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[ObservedBy(SlugObserver::class)]
class CourseCategory extends Model implements HasMedia
{
    use InteractsWithMedia, Searchable;

    protected $table = 'course_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'status',
    ];

    // use Slug in the route model binding
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Searchable
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
        ];
    }

    // Relationships
    public function parent()
    {
        return $this->belongsTo(CourseCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(CourseCategory::class, 'parent_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    // Media Library
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('course_category_images')->singleFile();
    }
}
