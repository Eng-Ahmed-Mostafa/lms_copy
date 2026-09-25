<?php

namespace App\Repository\Api\Courses;

use App\Interface\Api\Courses\ChapterInterface;
use App\Models\Chapter;
use App\Trait\RepositoryTrait;

class ChapterRepository implements ChapterInterface
{
    use RepositoryTrait;

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
}
