<?php

namespace App\Repository\Api\Courses;

use App\Interface\Api\Courses\LessonInterface;
use App\Models\Lesson;
use App\Trait\RepositoryTrait;
use Illuminate\Support\Facades\Auth;

class LessonRepository implements LessonInterface
{
    use RepositoryTrait;

    // get all lessons
    public function index()
    {
        $lessons = Lesson::with(['chapter'])->get();
        return $this->returnData(true, 'Lessons retrieved successfully', 200, $lessons);
    }

    // create a new lesson
    public function store(array $data)
    {
        $lesson = Lesson::create([
            'chapter_id' => $data['chapter_id'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'type' => $data['type'] ?? null,
            'duration' => $data['duration'] ?? null,
            'order' => $data['order'] ?? null,
            'is_free' => $data['is_free'] ?? false,
            'status' => $data['status'],
            'approval_status' => $data['approval_status'] ?? 'draft',
            'published_at' => $data['status'] === 'published' ? now() : null,
        ]);
        return $this->returnData(true, 'Lesson created successfully', 201, $lesson);
    }

    // get a single lesson
    public function show(string $id)
    {
        $lesson = Lesson::with(['chapter'])->where('id', $id)->first();
        if (!$lesson) {
            return $this->returnData(false, 'Lesson not found', 404, null);
        }
        return $this->returnData(true, 'Lesson retrieved successfully', 200, $lesson);
    }

    // update a lesson
    public function update(array $data, string $id)
    {
        $lesson = Lesson::where('id', $id)->first();

        if (!$lesson) {
            return $this->returnData(false, 'Lesson not found', 404, null);
        }

        $lesson->update([
            'chapter_id' => $data['chapter_id'] ?? $lesson->chapter_id,
            'title' => $data['title'] ?? $lesson->title,
            'description' => $data['description'] ?? $lesson->description,
            'type' => $data['type'] ?? $lesson->type,
            'duration' => $data['duration'] ?? $lesson->duration,
            'order' => $data['order'] ?? $lesson->order,
            'is_free' => $data['is_free'] ?? $lesson->is_free,
            'status' => $data['status'] ?? $lesson->status,
            'approval_status' => $data['approval_status'] ?? $lesson->approval_status,
            'published_at' =>  $lesson->published_at ?? ($data['status'] === 'published' ? now() : null),
        ]);
        return $this->returnData(true, 'Lesson updated successfully', 200, $lesson);
    }

    // delete a lesson
    public function destroy(string $id)
    {
        $lesson = Lesson::where('id', $id)->first();
        if (!$lesson) {
            return $this->returnData(false, 'Lesson not found', 404, null);
        }
        $lesson->delete();
        return $this->returnData(true, 'Lesson deleted successfully', 200, null);
    }

    // get all versions of a lesson
    public function getVersions(string $id)
    {
        $lesson = Lesson::with(['versions'])->where('id', $id)->first();
        if (!$lesson) {
            return $this->returnData(false, 'Lesson not found', 404, null);
        }
        return $this->returnData(true, 'Lesson versions retrieved successfully', 200, $lesson->versions);
    }

    // create a new version for a lesson
    public function createVersion(array $data, string $id)
    {
        $lesson = Lesson::where('id', $id)->first();
        if (!$lesson) {
            return $this->returnData(false, 'Lesson not found', 404, null);
        }
        $version = $lesson->versions()->create([
            'lesson_id' => $id,
            'version_number' => $lesson->versions()->count() + 1,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'draft',
            'created_by' => Auth::id() ?? null,
            'approved_by' =>  $data['status'] === 'approved' ? Auth::id() : null,
            'approved_at' => $data['approved_at'] ?? null,
            'published_at' => $data['published_at'] ?? null
        ]);
        return $this->returnData(true, 'Lesson version created successfully', 201, $version);
    }

    // get a specific version of a lesson
    public function getVersion(string $id, string $versionId)
    {
        $lesson = Lesson::with(['versions'])->where('id', $id)->first();
        if (!$lesson) {
            return $this->returnData(false, 'Lesson not found', 404, null);
        }
        $version = $lesson->versions()->where('id', $versionId)->first();
        if (!$version) {
            return $this->returnData(false, 'Lesson version not found', 404, null);
        }
        return $this->returnData(true, 'Lesson version retrieved successfully', 200, $version);
    }

    // submit a lesson for approval
    public function submitForApproval(string $id)
    {
        $lesson = Lesson::where('id', $id)->first();
        if (!$lesson) {
            return $this->returnData(false, 'Lesson not found', 404, null);
        }
        $lesson->update(['approval_status' => 'pending']);
        return $this->returnData(true, 'Lesson submitted for approval successfully', 200, $lesson);
    }

    // publish a lesson
    public function publish(string $id)
    {
        $lesson = Lesson::where('id', $id)->first();
        if (!$lesson) {
            return $this->returnData(false, 'Lesson not found', 404, null);
        }
        $lesson->update(['status' => 'published', 'published_at' => now()]);
        return $this->returnData(true, 'Lesson published successfully', 200, $lesson);
    }

    // unpublish a lesson
    public function unpublish(string $id)
    {
        $lesson = Lesson::where('id', $id)->first();
        if (!$lesson) {
            return $this->returnData(false, 'Lesson not found', 404, null);
        }
        $lesson->update(['status' => 'draft', 'published_at' => null]);
        return $this->returnData(true, 'Lesson unpublished successfully', 200, $lesson);
    }

    // reorder lessons
    public function reorder(array $data, string $id)
    {
        $lesson = Lesson::where('id', $id)->first();
        if (!$lesson) {
            return $this->returnData(false, 'Lesson not found', 404, null);
        }

        $lesson->update(['order' => $data['order']]);

        return $this->returnData(true, 'Lesson reordered successfully', 200, $lesson);
    }
}
