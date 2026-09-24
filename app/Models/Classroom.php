<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'grade_id',
        'academic_year_id',
        'name',
        'code',
        'capacity',
        'status',
    ];

    // use cast for capacity and status
    protected $casts = [
        'capacity' => 'integer',
        'status' => 'string',
    ];

    // Relationships
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'classroom_student', 'classroom_id', 'student_id');
    }
}
