<?php

namespace App\Http\Controllers\Api\Enrollment;

use App\Enum\EnrollmentSource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Enrollment\CreateEnrollmentRequest;
use App\Http\Resources\Enrollment\EnrollmentResource;
use App\Models\Course;
use App\Models\Enrollment;
use App\Services\Enrollment\EnrollmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function __construct(private EnrollmentService $enrollmentService) {}

    public function store(CreateEnrollmentRequest $request): JsonResponse
    {
        $course = Course::findOrFail($request->input('course_id'));

        $this->authorize('enroll', [Enrollment::class, $course]);

        $enrollment = $this->enrollmentService->enroll(Auth::user(), $course, EnrollmentSource::SELF);

        return response()->json([
            'success' => true,
            'message' => 'Enrollment Created successfully.',
            'data' => new EnrollmentResource($enrollment),
        ], 201);
    }

    public function show(Enrollment $enrollment): JsonResponse
    {
        $this->authorize('view', $enrollment);

        $enrollment->load(['user', 'course']);

        return response()->json([
            'success' => true,
            'message' => 'Enrollment retrieved successfully.',
            'data' => new EnrollmentResource($enrollment),
        ]);
    }

    public function cancel(CreateEnrollmentRequest $request, Enrollment $enrollment): JsonResponse
    {
        $this->authorize('cancel', $enrollment);

        $reason = $request->input('reason');

        $this->enrollmentService->cancel($enrollment, $reason);

        return response()->json([
            'success' => true,
            'message' => 'Enrollment canceled successfully.',
            'data' => new EnrollmentResource($enrollment),
        ]);
    }
}
