<?php

namespace App\Repository\Api\Courses;

use App\Interface\Api\Courses\ChapterInterface;
use App\Models\Chapter;
use App\Trait\RepositoryTrait;

class ChapterRepository implements ChapterInterface
{
    use RepositoryTrait;

    // search chapters
    public function search(array $data)
    {
        $query = Chapter::search($data['q'] ?? '')
            ->query(function ($query) use ($data) {
                $query->with(['course', 'lessons']);
            })->paginate($data['per_page'] ?? 10);
        return $this->returnData(true, 'Chapters retrieved successfully', 200, $query);
    }

    // get all chapters
    public function index()
    {
        $chapters = Chapter::get();
        return $this->returnData(true, 'Chapters retrieved successfully', 200, $chapters);
    }

    // create a new chapter
    public function store(array $data)
    {
        $chapter = Chapter::create([
            'course_id' => $data['course_id'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'order' => $data['order'] ?? 0,
            'status' => $data['status'] ?? 'draft',
        ]);
        return $this->returnData(true, 'Chapter created successfully', 201, $chapter);
    }

    // get a single chapter
    public function show(string $id)
    {
        $chapter = Chapter::find($id);
        if (!$chapter) {
            return $this->returnData(false, 'Chapter not found', 404);
        }
        return $this->returnData(true, 'Chapter retrieved successfully', 200, $chapter);
    }

    // update a chapter
    public function update(array $data, string $id)
    {
        $chapter = Chapter::find($id);
        if (!$chapter) {
            return $this->returnData(false, 'Chapter not found', 404);
        }
        $chapter->update([
            'course_id' => $data['course_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'order' => $data['order'],
            'status' => $data['status'],
        ]);
        return $this->returnData(true, 'Chapter updated successfully', 200, $chapter);
    }

    // delete a chapter
    public function destroy(string $id)
    {
        $chapter = Chapter::find($id);
        if (!$chapter) {
            return $this->returnData(false, 'Chapter not found', 404);
        }
        $chapter->delete();
        return $this->returnData(true, 'Chapter deleted successfully', 200, null);
    }

    // get lessons for a specific chapter
    public function getLessons(string $id)
    {
        $chapter = Chapter::with('lessons')->find($id);
        if (!$chapter) {
            return $this->returnData(false, 'Chapter not found', 404);
        }
        $lessons = $chapter->lessons;
        return $this->returnData(true, 'Lessons retrieved successfully', 200, $lessons);
    }

    // add a lesson to a specific chapter
    public function addLesson(array $data, string $id)
    {
        $chapter = Chapter::with('lessons')->find($id);
        if (!$chapter) {
            return $this->returnData(false, 'Chapter not found', 404);
        }
        $lesson = $chapter->lessons()->create([
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
        return $this->returnData(true, 'Lesson added successfully', 201, $lesson);
    }

    // reorder chapters
    public function reorder(array $data, string $id)
    {
        $chapter = Chapter::find($id);
        if (!$chapter) {
            return $this->returnData(false, 'Chapter not found', 404);
        }
        $chapter->update([
            'order' => $data['order'],
        ]);
        return $this->returnData(true, 'Chapter reordered successfully', 200, $chapter);
    }
}
