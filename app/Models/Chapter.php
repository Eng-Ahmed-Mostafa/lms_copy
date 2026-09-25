<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
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

    // Relationships
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
