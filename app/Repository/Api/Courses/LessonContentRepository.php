<?php

namespace App\Repository\Api\Courses;

use App\Interface\Api\Courses\LessonContentInterface;
use App\Models\LessonContent;
use App\Trait\RepositoryTrait;

class LessonContentRepository implements LessonContentInterface
{
    use RepositoryTrait;

    // store a newly created resource in storage.
    public function store(array $data)
    {
        $lessonContent = LessonContent::create([
            'lesson_version_id' => $data['lesson_version_id'],
            'type' => $data['type'],
            'content' => $data['content'] ?? null,
            'file_path' => $data['file_path'] ?? null,
            'video_url' => $data['video_url'] ?? null,
            'duration' => $data['duration'] ?? 0,
            'order' => $data['order'] ?? 0,
            'metadata' => $data['metadata'] ?? null,
        ]);

        return $this->returnData(true ,'Lesson content created successfully', 201, $lessonContent);
    }

    // display the specified resource.
    public function show(string $id)
    {
        $lessonContent = LessonContent::find($id);

        if (!$lessonContent) {
            return $this->returnData(false, 'Lesson content not found', 404);
        }

        return $this->returnData(true, 'Lesson content retrieved successfully', 200, $lessonContent);
    }

    // update the specified resource in storage.
    public function update(string $id, array $data)
    {
        $lessonContent = LessonContent::find($id);

        if (!$lessonContent) {
            return $this->returnData(false, 'Lesson content not found', 404);
        }

        $lessonContent->update([
            'lesson_version_id' => $data['lesson_version_id'] ?? $lessonContent->lesson_version_id,
            'type' => $data['type'] ?? $lessonContent->type,
            'content' => $data['content'] ?? $lessonContent->content,
            'file_path' => $data['file_path'] ?? $lessonContent->file_path,
            'video_url' => $data['video_url'] ?? $lessonContent->video_url,
            'duration' => $data['duration'] ?? $lessonContent->duration,
            'order' => $data['order'] ?? $lessonContent->order,
            'metadata' => $data['metadata'] ?? $lessonContent->metadata,
        ]);

        return $this->returnData(true, 'Lesson content updated successfully', 200, $lessonContent);
    }

    // remove the specified resource from storage.
    public function destroy(string $id)
    {
        $lessonContent = LessonContent::find($id);

        if (!$lessonContent) {
            return $this->returnData(false, 'Lesson content not found', 404);
        }

        $lessonContent->delete();

        return $this->returnData(true, 'Lesson content deleted successfully', 200);
    }

    // reorder the specified resource in storage.
    public function reorder(string $id, array $data)
    {
        $lessonContent = LessonContent::find($id);

        if (!$lessonContent) {
            return $this->returnData(false, 'Lesson content not found', 404);
        }

        $lessonContent->update([
            'order' => $data['order'] ?? $lessonContent->order,
        ]);

        return $this->returnData(true, 'Lesson content reordered successfully', 200, $lessonContent);
    }
}
