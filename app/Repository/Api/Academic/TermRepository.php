<?php

namespace App\Repository\Api\Academic;

use App\Interface\Api\Academic\TermInterface;
use App\Models\Term;
use App\Trait\RepositoryTrait;

class TermRepository implements TermInterface
{
    use RepositoryTrait;

    // get all terms
    public function index()
    {
        $terms = Term::with('academicYear')->get();
        return $this->returnData(true, 'Terms retrieved successfully.', 200, $terms);
    }

    // create a new term
    public function store(array $data)
    {
        $term = Term::create([
            'academic_year_id' => $data['academic_year_id'],
            'name' => $data['name'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status']
        ]);
        return $this->returnData(true, 'Term created successfully.', 201, $term);
    }

    // get a specific term
    public function show(string $id)
    {
        $term = Term::with('academicYear')->find($id);
        if (!$term) {
            return $this->returnData(false, 'Term not found.', 404);
        }
        return $this->returnData(true, 'Term retrieved successfully.', 200, $term);
    }

    // update a specific term
    public function update(array $data, string $id)
    {
        $term = Term::find($id);
        if (!$term) {
            return $this->returnData(false, 'Term not found.', 404);
        }

        $term->update([
            'academic_year_id' => $data['academic_year_id'],
            'name' => $data['name'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status']
        ]);

        return $this->returnData(true, 'Term updated successfully.', 200, $term);
    }

    // delete a specific term
    public function destroy(string $id)
    {
        $term = Term::find($id);
        if (!$term) {
            return $this->returnData(false, 'Term not found.', 404);
        }

        $term->delete();
        return $this->returnData(true, 'Term deleted successfully.', 200);
    }

    // activate a specific term
    public function activate(string $id)
    {
        $term = Term::find($id);
        if (!$term) {
            return $this->returnData(false, 'Term not found.', 404);
        }

        $term->status = 'active';
        $term->save();

        return $this->returnData(true, 'Term activated successfully.', 200, $term);
    }

    // deactivate a specific term
    public function deactivate(string $id)
    {
        $term = Term::find($id);
        if (!$term) {
            return $this->returnData(false, 'Term not found.', 404);
        }

        $term->status = 'inactive';
        $term->save();

        return $this->returnData(true, 'Term deactivated successfully.', 200, $term);
    }
}
