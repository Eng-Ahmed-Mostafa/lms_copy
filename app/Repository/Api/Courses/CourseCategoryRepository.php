<?php

namespace App\Repository\Api\Courses;

use App\Interface\Api\Courses\CourseCategoryInterface;
use App\Models\CourseCategory;
use App\Trait\RepositoryTrait;

class CourseCategoryRepository implements CourseCategoryInterface
{
    use RepositoryTrait;

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
            'parent_id' => $data['parent_id'] ?? null,
            'status' => $data['status'] ?? 1,
        ]);

        if(!empty($data['image'])) {
            $courseCategory->addMedia($data['image'])->toMediaCollection('course_category_images');
        }

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
            'parent_id' => $data['parent_id'] ?? $courseCategory->parent_id,
            'status' => $data['status'] ?? $courseCategory->status,
        ]);

        if(!empty($data['image'])) {
            $courseCategory->addMedia($data['image'])->toMediaCollection('course_category_images');
        }

        return $this->returnData(true, 'Course Category Updated Successfully', 200, $courseCategory);
    }

    // delete a specific course category by slug
    public function destroy(string $slug)
    {
        $courseCategory = CourseCategory::where('slug', $slug)->first();

        if (!$courseCategory) {
            return $this->returnData(false, 'Course Category Not Found', 404);
        }

        $courseCategory->clearMediaCollection('course_category_images');

        $courseCategory->delete();

        return $this->returnData(true, 'Course Category Deleted Successfully', 200);
    }

    // get courses by category
    public function getCoursesByCategory(string $slug)
    {
        $courseCategory = CourseCategory::with('courses')->where('slug', $slug)->first();
        if (!$courseCategory) {
            return $this->returnData(false, 'Course Category Not Found', 404);
        }
        $courses = $courseCategory->courses;
        return $this->returnData(true, 'Retrieved Courses Successfully', 200, $courses);
    }
}
