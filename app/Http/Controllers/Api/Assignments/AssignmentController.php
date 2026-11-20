<?php

namespace App\Http\Controllers\Api\Assignments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Assignments\AssignmentRequest;
use App\Http\Resources\Assignments\AssignmentResource;
use App\Services\Assignments\AssignmentService;
use App\Trait\ResponseTrait;
use App\Models\Assignment;

class AssignmentController extends Controller
{
    use ResponseTrait;
    public function __construct(private readonly AssignmentService $assignmentService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Assignment::class);
        $results = $this->assignmentService->getAllAssignments();
        return $this->finalResponse($results, AssignmentResource::collection($results['data']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssignmentRequest $request)
    {
        $this->authorize('create', Assignment::class);
        $result = $this->assignmentService->createAssignment($request->validated());
        return $this->finalResponse($result, new AssignmentResource($result['data']));
    }

    /**
     * Display the specified resource.
     */
    public function show(Assignment $assignment)
    {
        $this->authorize('view', $assignment);
        $result = $this->assignmentService->getAssignmentById($assignment->id);
        return $this->finalResponse($result, new AssignmentResource($result['data']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AssignmentRequest $request, Assignment $assignment)
    {
        $this->authorize('update', $assignment);
        $result = $this->assignmentService->updateAssignment($assignment->id, $request->validated());
        return $this->finalResponse($result, new AssignmentResource($result['data']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment)
    {
        $this->authorize('delete', $assignment);
        $result = $this->assignmentService->deleteAssignment($assignment->id);
        return $this->finalResponse($result);
    }

    /**
     * Publish the specified assignment.
     */
    public function publish(Assignment $assignment)
    {
        $this->authorize('publish', $assignment);
        $result = $this->assignmentService->publishAssignment($assignment->id);
        return $this->finalResponse($result, new AssignmentResource($result['data']));
    }

    /**
     * Close the specified assignment.
     */
    public function close(Assignment $assignment)
    {
        $this->authorize('unpublish', $assignment);
        $result = $this->assignmentService->closeAssignment($assignment->id);
        return $this->finalResponse($result, new AssignmentResource($result['data']));
    }
}
