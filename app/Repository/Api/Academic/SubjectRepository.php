<?php

namespace App\Repository\Api\Academic;

use App\Interface\Api\Academic\SubjectInterface;
use App\Models\Subject;
use App\Trait\RepositoryTrait;

class SubjectRepository implements SubjectInterface
{
    use RepositoryTrait;

    // get all subjects
    public function index()
    {
        $subjects = Subject::get();
        return $this->returnData(true, 'Subjects retrieved successfully', 200, $subjects);
    }

    // store a new subject
    public function store(array $data)
    {
        $subject = Subject::create($data);
        return $this->returnData(true, 'Subject created successfully', 201, $subject);
    }

    // get a single subject by slug
    public function show(string $slug)
    {
        $subject = Subject::where('slug', $slug)->first();
        if (!$subject) {
            return $this->returnData(false, 'Subject not found', 404);
        }
        return $this->returnData(true, 'Subject retrieved successfully', 200, $subject);
    }

    // update a subject by slug
    public function update(array $data, string $slug)
    {
        $subject = Subject::where('slug', $slug)->first();
        if (!$subject) {
            return $this->returnData(false, 'Subject not found', 404);
        }
        $subject->update($data);
        return $this->returnData(true, 'Subject updated successfully', 200, $subject);
    }

    // delete a subject by slug
    public function destroy(string $slug)
    {
        $subject = Subject::where('slug', $slug)->first();
        if (!$subject) {
            return $this->returnData(false, 'Subject not found', 404);
        }
        $subject->delete();
        return $this->returnData(true, 'Subject deleted successfully', 200);
    }
}
