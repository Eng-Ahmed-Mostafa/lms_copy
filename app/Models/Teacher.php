<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'employee_number',
        'bio',
        'qualification',
        'specialization',
        'experience_years',
        'hire_date',
        'status',
    ];

    // Casts
    protected $casts = [
        'hire_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
