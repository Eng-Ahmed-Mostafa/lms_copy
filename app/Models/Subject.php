<?php

namespace App\Models;

use App\Observers\SlugObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(SlugObserver::class)]
class Subject extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'code',
        'description',
        'icon',
        'status',
    ];

    // set the default value for the status attribute
    protected $casts = [
        'status' => 'string',
    ];

    // use slug for route model binding
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
