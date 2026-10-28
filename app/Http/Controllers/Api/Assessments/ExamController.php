<?php

namespace App\Http\Controllers\Api\Assessments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Assessments\StoreExamRequest;
use App\Http\Requests\Api\Assessments\UpdateExamRequest;
use App\Http\Requests\Assessments\ExamQuestionRequest;
use App\Http\Requests\Assessments\ExamRequest;
use App\Http\Resources\Api\Assessments\ExamResource;
use App\Interface\Api\Assessments\ExamInterface;
use App\Models\Exam;
use App\Services\Assessments\ExamService;
use App\Services\Assessments\ExamStatisticsService;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function __construct(
        private readonly ExamService $examService,
        private readonly ExamStatisticsService $examStatisticsService,
    ) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', Exam::class);

        $exams = $this->examService->index($request->only(['course_id', 'status', 'per_page']));

        return ExamResource::collection($exams)->additional([
            'meta' => [
                'total' => $exams->total(),
                'per_page' => $exams->perPage(),
                'current_page' => $exams->currentPage(),
                'last_page' => $exams->lastPage(),
            ],
        ]);
    }

    public function store(StoreExamRequest $request)
    {
        $this->authorize('create', Exam::class);

        $exam = $this->examService->create($request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Exam created successfully.',
            'data' => new ExamResource($exam),
        ], 201);
    }

    public function show(Exam $exam)
    {
        $this->authorize('view', $exam);

        $exam = $this->examService->show($exam->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Exam retrieved successfully.',
            'data' => new ExamResource($exam),
        ]);
    }

    public function update(UpdateExamRequest $request, Exam $exam)
    {
        $this->authorize('update', $exam);

        $exam = $this->examService->update($exam->id, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Exam updated successfully.',
            'data' => new ExamResource($exam),
        ]);
    }

    public function destroy(Exam $exam)
    {
        $this->authorize('delete', $exam);

        $this->examService->delete($exam->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Exam deleted successfully.',
            'data' => null,
        ]);
    }

    public function publish(Exam $exam)
    {
        $this->authorize('publish', $exam);

        $exam = $this->examService->publish($exam->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Exam published successfully.',
            'data' => new ExamResource($exam),
        ]);
    }

    public function statistics(Exam $exam)
    {
        $this->authorize('viewStatistics', $exam);

        $statistics = $this->examStatisticsService->get($exam->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Exam statistics retrieved successfully.',
            'data' => $statistics,
        ]);
    }
}
