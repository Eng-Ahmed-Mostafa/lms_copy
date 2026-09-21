<?php

namespace App\Repository\Api\Academic;

use App\Interface\Api\Academic\AcademicYearInterface;
use App\Models\AcademicYear;
use App\Trait\RepositoryTrait;

class AcademicYearRepository implements AcademicYearInterface
{
    use RepositoryTrait;

    public function index()
    {
        $academicYears = AcademicYear::all();
        return $this->returnData(true, 'Academic Years retrieved successfully', 200, $academicYears);
    }

    public function store(array $data)
    {
        $academicYear = AcademicYear::create([
            'name' => $data['name'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status'],
            'is_current' => $data['is_current']
        ]);
        return $this->returnData(true, 'Academic Year created successfully', 201, $academicYear);
    }

    public function show(string $id)
    {
        $academicYear = AcademicYear::find($id);
        if (!$academicYear) {
            return $this->returnData(false, 'Academic Year not found', 404, null);
        }
        return $this->returnData(true, 'Academic Year retrieved successfully', 200, $academicYear);
    }

    public function update(string $id, array $data)
    {
        $academicYear = AcademicYear::find($id);
        if (!$academicYear) {
            return $this->returnData(false, 'Academic Year not found', 404, null);
        }
        $academicYear->update([
            'name' => $data['name'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status'],
            'is_current' => $data['is_current']
        ]);
        return $this->returnData(true, 'Academic Year updated successfully', 200, $academicYear);
    }

    public function destroy(string $id)
    {
        $academicYear = AcademicYear::find($id);
        if (!$academicYear) {
            return $this->returnData(false, 'Academic Year not found', 404, null);
        }
        $academicYear->delete();
        return $this->returnData(true, 'Academic Year deleted successfully', 200, null);
    }

    public function activate(string $id)
    {
        $academicYear = AcademicYear::find($id);
        if (!$academicYear) {
            return $this->returnData(false, 'Academic Year not found', 404, null);
        }
        $academicYear->update(['status' => 'active']);
        return $this->returnData(true, 'Academic Year activated successfully', 200, $academicYear);
    }

    public function deactivate(string $id)
    {
        $academicYear = AcademicYear::find($id);
        if (!$academicYear) {
            return $this->returnData(false, 'Academic Year not found', 404, null);
        }
        $academicYear->update(['status' => 'inactive']);
        return $this->returnData(true, 'Academic Year deactivated successfully', 200, $academicYear);
    }

    public function getCurrentAcademicYear()
    {
        $academicYear = AcademicYear::where('is_current', true)->first();
        if (!$academicYear) {
            return $this->returnData(false, 'Current Academic Year not found', 404, null);
        }
        return $this->returnData(true, 'Current Academic Year retrieved successfully', 200, $academicYear);
    }
}
