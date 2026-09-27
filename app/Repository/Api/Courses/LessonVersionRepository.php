<?php

namespace App\Repository\Api\Courses;

use App\Interface\Api\Courses\LessonVersionInterface;
use App\Models\LessonVersion;
use App\Trait\RepositoryTrait;
use Illuminate\Support\Facades\Auth;

class LessonVersionRepository implements LessonVersionInterface
{
    use RepositoryTrait;

    // show a specific lesson version
    public function show(string $id)
    {
        $lessonVersion = LessonVersion::with(['lesson', 'creator', 'approver'])->find($id);
        if (!$lessonVersion) {
            return $this->returnData(false, 'Lesson version not found', 404);
        }
        return $this->returnData(true, 'Lesson version found', 200, $lessonVersion);
    }

    // update a specific lesson version
    public function update(string $id, array $data)
    {
        $lessonVersion = LessonVersion::find($id);
        if (!$lessonVersion) {
            return $this->returnData(false, 'Lesson version not found', 404);
        }
        $lessonVersion->update([
            'lesson_id' => $data['lesson_id'] ?? $lessonVersion->lesson_id,
            'version_number' => $lessonVersion->version_number, // Assuming version_number is auto-incremented or managed elsewhere
            'title' => $data['title'] ?? $lessonVersion->title,
            'description' => $data['description'] ?? $lessonVersion->description,
            'status' => $data['status'] ?? $lessonVersion->status,
            'created_by' => $lessonVersion->created_by ?? Auth::id(),
            'approved_by' => $lessonVersion->approved_by ?? ($data['status'] === 'approved' ? Auth::id() : null),
            'approved_at' => $data['approved_at'] ?? $lessonVersion->approved_at,
            'published_at' => $data['published_at'] ?? $lessonVersion->published_at
        ]);
        return $this->returnData(true, 'Lesson version updated', 200, $lessonVersion);
    }

    // delete a specific lesson version
    public function destroy(string $id)
    {
        $lessonVersion = LessonVersion::find($id);
        if (!$lessonVersion) {
            return $this->returnData(false, 'Lesson version not found', 404);
        }
        $lessonVersion->delete();
        return $this->returnData(true, 'Lesson version deleted', 200);
    }

    // submit a specific lesson version for review
    public function submitForReview(string $id)
    {
        $lessonVersion = LessonVersion::find($id);
        if (!$lessonVersion) {
            return $this->returnData(false, 'Lesson version not found', 404);
        }
        $lessonVersion->update(['status' => 'pending_review']);
        return $this->returnData(true, 'Lesson version submitted for review', 200, $lessonVersion);
    }

    // approve a specific lesson version
    public function approve(string $id)
    {
        $lessonVersion = LessonVersion::find($id);
        if (!$lessonVersion) {
            return $this->returnData(false, 'Lesson version not found', 404);
        }
        $authId = Auth::id();
        $lessonVersion->update(['status' => 'approved', 'approved_by' => $authId, 'approved_at' => now()]);
        return $this->returnData(true, 'Lesson version approved', 200, $lessonVersion);
    }

    // reject a specific lesson version
    public function reject(string $id)
    {
        $lessonVersion = LessonVersion::find($id);
        if (!$lessonVersion) {
            return $this->returnData(false, 'Lesson version not found', 404);
        }
        $authId = Auth::id();
        $lessonVersion->update(['status' => 'rejected', 'rejected_by' => $authId, 'rejected_at' => now()]);
        return $this->returnData(true, 'Lesson version rejected', 200, $lessonVersion);
    }

    // publish a specific lesson version
    public function publish(string $id)
    {
        $lessonVersion = LessonVersion::find($id);
        if (!$lessonVersion) {
            return $this->returnData(false, 'Lesson version not found', 404);
        }
        $authId = Auth::id();
        $lessonVersion->update(['status' => 'published', 'published_at' => now(), 'published_by' => $authId]);
        return $this->returnData(true, 'Lesson version published', 200, $lessonVersion);
    }
}
