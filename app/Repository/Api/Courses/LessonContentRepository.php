<?php

namespace App\Repository\Api\Courses;

use App\Interface\Api\Courses\LessonContentInterface;
use App\Models\LessonContent;
use App\Trait\RepositoryTrait;

class LessonContentRepository implements LessonContentInterface
{
    use RepositoryTrait;

    // Helper functions
    private function getMediaCollectionName(string $type): string
    {
        return match ($type) {
            'video' => 'lesson_videos',
            'file' => 'lesson_files',
            default => null,
        };
    }

    // store a newly created resource in storage.
    public function store(array $data)
    {
        $lessonContent = LessonContent::create([
            'lesson_version_id' => $data['lesson_version_id'],
            'type' => $data['type'],
            'content' => $data['content'] ?? null,
            'video_url' => $data['video_url'] ?? null,
            'duration' => $data['duration'] ?? 0,
            'order' => $data['order'] ?? 0,
            'metadata' => $data['metadata'] ?? null,
        ]);

        if(!empty($data['file']) && in_array($data['type'], ['video', 'file'])) {
            $mediaCollectionName = $this->getMediaCollectionName($data['type']);
            if ($mediaCollectionName) {
                $lessonContent->addMedia($data['file'])->toMediaCollection($mediaCollectionName);
            }
        }

        return $this->returnData(true ,'Lesson content created successfully', 201, $lessonContent->load('media'));
    }

    // display the specified resource.
    public function show(string $id)
    {
        $lessonContent = LessonContent::find($id);

        if (!$lessonContent) {
            return $this->returnData(false, 'Lesson content not found', 404);
        }

        return $this->returnData(true, 'Lesson content retrieved successfully', 200, $lessonContent->load('media'));
    }

    // update the specified resource in storage.
    public function update(string $id, array $data)
    {
        $lessonContent = LessonContent::find($id);

        if (!$lessonContent) {
            return $this->returnData(false, 'Lesson content not found', 404);
        }

        $oldType = $lessonContent->type;
        $newType = $data['type'] ?? $oldType;

        $lessonContent->update([
            'lesson_version_id' => $data['lesson_version_id'] ?? $lessonContent->lesson_version_id,
            'type' => $newType,
            'content' => $data['content'] ?? $lessonContent->content,
            'video_url' => $data['video_url'] ?? $lessonContent->video_url,
            'duration' => $data['duration'] ?? $lessonContent->duration,
            'order' => $data['order'] ?? $lessonContent->order,
            'metadata' => $data['metadata'] ?? $lessonContent->metadata,
        ]);

        if(!empty($data['file']) && in_array($newType, ['video', 'file'])) {
            $mediaCollectionName = $this->getMediaCollectionName($newType);
            if ($mediaCollectionName) {
                // Remove old media if type has changed
                if ($oldType !== $newType) {
                    $oldMediaCollectionName = $this->getMediaCollectionName($oldType);
                    if ($oldMediaCollectionName) {
                        $lessonContent->clearMediaCollection($oldMediaCollectionName);
                    }
                }
                // Add new media
                $lessonContent->addMedia($data['file'])->toMediaCollection($mediaCollectionName);
            }
        }

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
