<?php

namespace App\Repository\Api\Courses;

use App\Interface\Api\Courses\CourseInterface;
use App\Models\Course;
use App\Trait\RepositoryTrait;

class CourseRepository implements CourseInterface
{
    use RepositoryTrait;

    public function index()
    {
        $courses = Course::with(['teacher', 'subject', 'courseCategory'])->get();
        return $this->returnData(true, 'Courses retrieved successfully', 200, $courses);
    }

    public function store(array $data)
    {
        $courses = Course::create([
            'teacher_id' => $data['teacher_id'],
            'course_category_id' => $data['course_category_id'],
            'subject_id' => $data['subject_id'],
            'title' => $data['title'],
            'short_description' => $data['short_description'],
            'description' => $data['description'],
            'thumbnail' => $data['thumbnail'],
            'preview_video' => $data['preview_video'],
            'price' => $data['price'],
            'discount_price' => $data['discount_price'],
            'duration' => $data['duration'],
            'level' => $data['level'],
            'language' => $data['language'],
            'status' => $data['status'],
            'approval_status' => $data['approval_status'],
            'published_at' => $data['published_at'],
        ]);
        return $this->returnData(true, 'Course created successfully', 201, $courses);
    }

    public function show(string $slug)
    {
        $course = Course::with(['teacher', 'subject', 'courseCategory'])->where('slug', $slug)->first();
        if (!$course) {
            return $this->returnData(false, 'Course not found', 404, null);
        }
        return $this->returnData(true, 'Course retrieved successfully', 200, $course);
    }

    public function update(array $data, string $slug)
    {
        $course = Course::where('slug', $slug)->first();
        if (!$course) {
            return $this->returnData(false, 'Course not found', 404, null);
        }
        $course->update([
            'teacher_id' => $data['teacher_id'] ?? $course->teacher_id,
            'course_category_id' => $data['course_category_id'] ?? $course->course_category_id,
            'subject_id' => $data['subject_id'] ?? $course->subject_id,
            'title' => $data['title'] ?? $course->title,
            'short_description' => $data['short_description'] ?? $course->short_description,
            'description' => $data['description'] ?? $course->description,
            'thumbnail' => $data['thumbnail'] ?? $course->thumbnail,
            'preview_video' => $data['preview_video'] ?? $course->preview_video,
            'price' => $data['price'] ?? $course->price,
            'discount_price' => $data['discount_price'] ?? $course->discount_price,
            'duration' => $data['duration'] ?? $course->duration,
            'level' => $data['level'] ?? $course->level,
            'language' => $data['language'] ?? $course->language,
            'status' => $data['status'] ?? $course->status,
            'approval_status' => $data['approval_status'] ?? $course->approval_status,
            'published_at' => $data['published_at'] ?? $course->published_at,
        ]);
        return $this->returnData(true, 'Course updated successfully', 200, $course);
    }

    public function destroy(string $slug)
    {
        $course = Course::where('slug', $slug)->first();
        if (!$course) {
            return $this->returnData(false, 'Course not found', 404, null);
        }
        $course->delete();
        return $this->returnData(true, 'Course deleted successfully', 200, null);
    }

    public function getStudentsByCourse(string $slug)
    {
        $course = Course::where('slug', $slug)->first();
        if (!$course) {
            return $this->returnData(false, 'Course not found', 404, null);
        }
        $students = $course->students; // Assuming you have a relationship defined in the Course model
        return $this->returnData(true, 'Students retrieved successfully', 200, $students);
    }

    public function publishCourse(string $slug)
    {
        $course = Course::where('slug', $slug)->first();
        if (!$course) {
            return $this->returnData(false, 'Course not found', 404, null);
        }
        $course->update(['status' => 'active']);
        return $this->returnData(true, 'Course published successfully', 200, $course);
    }

    public function unpublishCourse(string $slug)
    {
        $course = Course::where('slug', $slug)->first();
        if (!$course) {
            return $this->returnData(false, 'Course not found', 404, null);
        }
        $course->update(['status' => 'inactive']);
        return $this->returnData(true, 'Course unpublished successfully', 200, $course);
    }

    public function archiveCourse(string $slug)
    {
        $course = Course::where('slug', $slug)->first();
        if (!$course) {
            return $this->returnData(false, 'Course not found', 404, null);
        }
        $course->update(['status' => 'archived']);
        return $this->returnData(true, 'Course archived successfully', 200, $course);
    }
}
