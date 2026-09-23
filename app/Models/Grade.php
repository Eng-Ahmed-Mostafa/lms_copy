<?php

namespace App\Models;

use App\Observers\SlugObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(SlugObserver::class)]
class Grade extends Model
{
    protected $fillable = [
        'name',
        'description',
        'order',
        'status',
    ];

    // use slug for route model binding
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Relationships
    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }
}
