<?php

namespace App\Models;

use App\Enum\EnrollmentSource;
use App\Enum\EnrollmentStatus;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'source',
        'status',
        'enrolled_at',
        'started_at',
        'completed_at',
        'cancelled_at',
        'expired_at',
        'cancellation_reason',
        'metadata',
    ];

    // Casts
    protected $casts = [
        'status' => EnrollmentStatus::class,
        'source' => EnrollmentSource::class,

        'enrolled_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'expired_at' => 'datetime',

        'metadata' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Status check methods
    public function isActive(): bool
    {
        return $this->status === EnrollmentStatus::ACTIVE;
    }

    public function isCompleted(): bool
    {
        return $this->status === EnrollmentStatus::COMPLETED;
    }

    public function isCancelled(): bool
    {
        return $this->status === EnrollmentStatus::CANCELLED;
    }

    public function isExpired(): bool
    {
        return $this->expired_at !== null && $this->expired_at->isPast();
    }
}
