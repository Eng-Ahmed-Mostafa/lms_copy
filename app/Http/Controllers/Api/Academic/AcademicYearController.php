<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Interface\Api\Academic\AcademicYearInterface;
use App\Trait\ResponseTrait;
use App\Http\Requests\Academic\AcademicYearRequest;

class AcademicYearController extends Controller
{
    use ResponseTrait;

    protected ?AcademicYearInterface $academicYearService;

    public function __construct(AcademicYearInterface $academicYearService)
    {
        $this->academicYearService = $academicYearService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->academicYearService->index();
        return $this->finalResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AcademicYearRequest $request)
    {
        $result = $this->academicYearService->store($request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->academicYearService->show($id);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AcademicYearRequest $request, string $id)
    {
        $result = $this->academicYearService->update($id, $request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->academicYearService->destroy($id);
        return $this->finalResponse($result);
    }

    /**
     * Activate the specified resource.
     */
    public function activate(string $id)
    {
        $result = $this->academicYearService->activate($id);
        return $this->finalResponse($result);
    }

    /**
     * Deactivate the specified resource.
     */
    public function deactivate(string $id)
    {
        $result = $this->academicYearService->deactivate($id);
        return $this->finalResponse($result);
    }

    /**
     * Get the current academic year.
     */
    public function getCurrentAcademicYear()
    {
        $result = $this->academicYearService->getCurrentAcademicYear();
        return $this->finalResponse($result);
    }
}
