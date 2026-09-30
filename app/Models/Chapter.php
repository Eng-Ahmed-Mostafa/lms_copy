<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Chapter extends Model
{
    use Searchable;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'order',
        'status',
    ];

    // Casts
    protected $casts = [
        'order' => 'integer',
        'status' => 'string',
    ];

    // Searchable
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'course_id' => $this->course_id,
            'title' => $this->title,
            'description' => $this->description,
            'order' => $this->order,
            'status' => $this->status,
        ];
    }

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
