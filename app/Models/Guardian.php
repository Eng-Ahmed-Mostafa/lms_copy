<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    protected $fillable = [
        'user_id',
        'occupation',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function children()
    {
        return $this->belongsToMany(Student::class, 'guardian_student')
                    ->withPivot('relationship', 'is_primary', 'can_view_grades', 'can_view_attendance', 'can_view_payments', 'can_receive_notifications')
                    ->withTimestamps();
    }
}
