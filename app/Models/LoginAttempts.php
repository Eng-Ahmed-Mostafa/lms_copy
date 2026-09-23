<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempts extends Model
{
    protected $table = 'login_attempts';

    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'successful',
        'attempted_at',
    ];

    // Casts
    protected $casts = [
        'successful' => 'boolean',
        'attempted_at' => 'datetime',
    ];

    // Disable timestamps for this model
    public $timestamps = false;

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
