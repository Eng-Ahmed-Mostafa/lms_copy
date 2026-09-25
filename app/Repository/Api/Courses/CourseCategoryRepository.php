<?php

namespace App\Repository\Api\Courses;

use App\Interface\Api\Courses\CourseCategoryInterface;
use App\Models\CourseCategory;
use App\Trait\RepositoryTrait;
use Illuminate\Support\Facades\Storage;

class CourseCategoryRepository implements CourseCategoryInterface
{
    use RepositoryTrait;


    // Handle image upload for course category
    private function handleImageUpload(array $data, ?CourseCategory $courseCategory = null)
    {
        if (isset($data['image'])) {
            // If updating and there's an existing image, delete it
            $this->removeImage($courseCategory);
            // Store the new image
            $path = $data['image']->store('course_categories', 'public');
            return $path;
        }
        return $courseCategory ? $courseCategory->image : null;
    }

    private function removeImage(?CourseCategory $courseCategory)
    {
        if ($courseCategory && $courseCategory->image) {
            Storage::disk('public')->delete($courseCategory->image);
        }
    }

    // get all course categories
    public function index()
    {
        $courseCategories = CourseCategory::with('parent', 'children')->get();
        return $this->returnData(true, 'Retrieved Course Categories Successfully', 200, $courseCategories);
    }

    // create a new course category
    public function store(array $data)
    {
        $courseCategory = CourseCategory::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'image' => $this->handleImageUpload($data),
            'parent_id' => $data['parent_id'] ?? null,
            'status' => $data['status'] ?? 1,
        ]);
        return $this->returnData(true, 'Course Category Created Successfully', 201, $courseCategory);
    }

    // get a specific course category by slug
    public function show(string $slug)
    {
        $courseCategory = CourseCategory::where('slug', $slug)->first();
        if (!$courseCategory) {
            return $this->returnData(false, 'Course Category Not Found', 404);
        }
        return $this->returnData(true, 'Retrieved Course Category Successfully', 200, $courseCategory);
    }

    // update a specific course category by slug
    public function update(string $slug, array $data)
    {
        $courseCategory = CourseCategory::where('slug', $slug)->first();
        if (!$courseCategory) {
            return $this->returnData(false, 'Course Category Not Found', 404);
        }
        $courseCategory->update([
            'name' => $data['name'] ?? $courseCategory->name,
            'description' => $data['description'] ?? $courseCategory->description,
            'image' => $this->handleImageUpload($data, $courseCategory),
            'parent_id' => $data['parent_id'] ?? $courseCategory->parent_id,
            'status' => $data['status'] ?? $courseCategory->status,
        ]);
        return $this->returnData(true, 'Course Category Updated Successfully', 200, $courseCategory);
    }

    // delete a specific course category by slug
    public function destroy(string $slug)
    {
        $courseCategory = CourseCategory::where('slug', $slug)->first();
        if (!$courseCategory) {
            return $this->returnData(false, 'Course Category Not Found', 404);
        }
        $this->removeImage($courseCategory);
        $courseCategory->delete();
        return $this->returnData(true, 'Course Category Deleted Successfully', 200);
    }
}
