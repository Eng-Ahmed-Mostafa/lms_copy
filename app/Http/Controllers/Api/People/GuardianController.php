<?php

namespace App\Http\Controllers\Api\People;

use App\Http\Controllers\Controller;
use App\Http\Requests\People\GuardianRequest;
use App\Interface\Api\People\GuardianInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    use ResponseTrait;

    protected ?GuardianInterface $guardianService;

    public function __construct(GuardianInterface $guardianService)
    {
        $this->guardianService = $guardianService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->guardianService->index();
        return $this->finalResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GuardianRequest $request)
    {
        $result = $this->guardianService->store($request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->guardianService->show($id);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GuardianRequest $request, string $id)
    {
        $result = $this->guardianService->update($id, $request->all());
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->guardianService->destroy($id);
        return $this->finalResponse($result);
    }

    /**
     * Get the children of a guardian.
     */
    public function getChildren(string $guardianId)
    {
        $result = $this->guardianService->getChildren($guardianId);
        return $this->finalResponse($result);
    }

    /**
     * Add a child to a guardian.
     */
    public function addChild(Request $request, string $guardianId)
    {
        $result = $this->guardianService->addChild($guardianId, $request->all());
        return $this->finalResponse($result);
    }

    /**
     * Remove a child from a guardian.
     */
    public function removeChild(string $guardianId, string $childId)
    {
        $result = $this->guardianService->removeChild($guardianId, $childId);
        return $this->finalResponse($result);
    }

    /**
     * Get the Grades for a specific child of a guardian.
     */
    public function getGradesForChild(string $guardianId, string $childId)
    {
        $result = $this->guardianService->getGradesForChild($guardianId, $childId);
        return $this->finalResponse($result);
    }
}
