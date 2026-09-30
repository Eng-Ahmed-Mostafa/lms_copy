<?php

namespace App\Repository\Api\Courses;

use App\Interface\Api\Courses\CourseInterface;
use App\Models\Course;
use App\Trait\RepositoryTrait;

class CourseRepository implements CourseInterface
{
    use RepositoryTrait;

    // get all courses
    public function index()
    {
        $courses = Course::with(['teacher', 'subject', 'courseCategory'])->get();
        return $this->returnData(true, 'Courses retrieved successfully', 200, $courses->load('media'));
    }

    // create a new course
    public function store(array $data)
    {
        $courses = Course::create([
            'teacher_id' => $data['teacher_id'],
            'course_category_id' => $data['course_category_id'],
            'subject_id' => $data['subject_id'],
            'title' => $data['title'],
            'short_description' => $data['short_description'],
            'description' => $data['description'],
            'price' => $data['price'],
            'discount_price' => $data['discount_price'],
            'duration' => $data['duration'],
            'level' => $data['level'],
            'language' => $data['language'],
            'status' => $data['status'],
            'approval_status' => $data['approval_status'],
            'published_at' => $data['published_at'],
        ]);

        if (!empty($data['thumbnail'])) {
            $courses->addMedia($data['thumbnail'])->toMediaCollection('course_thumbnail');
        }

        if (!empty($data['preview_video'])) {
            $courses->addMedia($data['preview_video'])->toMediaCollection('course_preview_video');
        }

        return $this->returnData(true, 'Course created successfully', 201, $courses->load('media'));
    }

    // get a single course
    public function show(string $slug)
    {
        $course = Course::with(['teacher', 'subject', 'courseCategory'])->where('slug', $slug)->first();
        if (!$course) {
            return $this->returnData(false, 'Course not found', 404, null);
        }
        return $this->returnData(true, 'Course retrieved successfully', 200, $course->load('media'));
    }

    // update a course
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
            'price' => $data['price'] ?? $course->price,
            'discount_price' => $data['discount_price'] ?? $course->discount_price,
            'duration' => $data['duration'] ?? $course->duration,
            'level' => $data['level'] ?? $course->level,
            'language' => $data['language'] ?? $course->language,
            'status' => $data['status'] ?? $course->status,
            'approval_status' => $data['approval_status'] ?? $course->approval_status,
            'published_at' => $data['published_at'] ?? $course->published_at,
        ]);

        if (!empty($data['thumbnail'])) {
            $course->addMedia($data['thumbnail'])->toMediaCollection('course_thumbnail');
        }

        if (!empty($data['preview_video'])) {
            $course->addMedia($data['preview_video'])->toMediaCollection('course_preview_video');
        }

        return $this->returnData(true, 'Course updated successfully', 200, $course->load('media'));
    }

    // delete a course
    public function destroy(string $slug)
    {
        $course = Course::where('slug', $slug)->first();
        if (!$course) {
            return $this->returnData(false, 'Course not found', 404, null);
        }
        $course->delete();
        return $this->returnData(true, 'Course deleted successfully', 200, null);
    }

    // get chapters of a specific course
    public function getChaptersByCourse(string $slug)
    {
        $course = Course::with('chapters')->where('slug', $slug)->first();
        if (!$course) {
            return $this->returnData(false, 'Course not found', 404, null);
        }
        return $this->returnData(true, 'Chapters retrieved successfully', 200, $course->chapters);
    }

    // add a chapter to a specific course
    public function addChapterToCourse(array $data, string $slug)
    {
        $course = Course::with('chapters')->where('slug', $slug)->first();
        if (!$course) {
            return $this->returnData(false, 'Course not found', 404, null);
        }
        $chapter = $course->chapters()->create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'order' => $data['order'] ?? 0,
            'status' => $data['status'] ?? 'draft',
        ]);
        return $this->returnData(true, 'Chapter added to course successfully', 201, $chapter);
    }

    // get lessons of a specific course
    public function getLessonsByCourse(string $slug)
    {
        $course = Course::with('chapters.lessons')->where('slug', $slug)->first();
        if (!$course) {
            return $this->returnData(false, 'Course not found', 404, null);
        }
        $lessons = $course->chapters->flatMap(function ($chapter) {
            return $chapter->lessons;
        });
        return $this->returnData(true, 'Lessons retrieved successfully', 200, $lessons);
    }

    // get students enrolled in a specific course
    public function getStudentsByCourse(string $slug)
    {
        $course = Course::where('slug', $slug)->first();
        if (!$course) {
            return $this->returnData(false, 'Course not found', 404, null);
        }
        $students = $course->students; // Assuming you have a relationship defined in the Course model
        return $this->returnData(true, 'Students retrieved successfully', 200, $students);
    }

    // submit a specific course for review
    public function submitCourseForReview(string $slug)
    {
        $course = Course::where('slug', $slug)->first();
        if (!$course) {
            return $this->returnData(false, 'Course not found', 404, null);
        }
        $course->update(['approval_status' => 'pending']);
        return $this->returnData(true, 'Course submitted for review successfully', 200, $course);
    }

    // publish a specific course
    public function publishCourse(string $slug)
    {
        $course = Course::where('slug', $slug)->first();
        if (!$course) {
            return $this->returnData(false, 'Course not found', 404, null);
        }
        $course->update(['status' => 'active']);
        return $this->returnData(true, 'Course published successfully', 200, $course);
    }

    // unpublish a specific course
    public function unpublishCourse(string $slug)
    {
        $course = Course::where('slug', $slug)->first();
        if (!$course) {
            return $this->returnData(false, 'Course not found', 404, null);
        }
        $course->update(['status' => 'inactive']);
        return $this->returnData(true, 'Course unpublished successfully', 200, $course);
    }

    // archive a specific course
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
