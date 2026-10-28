<?php

namespace App\Http\Controllers\Api\Assessments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Assessments\AttachExamQuestionRequest;
use App\Http\Resources\Api\Assessments\ExamQuestionResource;
use App\Models\Exam;
use App\Services\Assessments\ExamQuestionService;
use Illuminate\Http\Request;

class ExamQuestionController extends Controller
{
    public function __construct(private readonly ExamQuestionService $examQuestionService) {}

    public function index(Exam $exam)
    {
        $this->authorize('view', $exam);

        $questions = $this->examQuestionService->index($exam->id);

        return ExamQuestionResource::collection($questions);
    }

    public function store(AttachExamQuestionRequest $request, Exam $exam)
    {
        $this->authorize('manageQuestions', $exam);

        $exam = $this->examQuestionService->attach($exam->id, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Question attached to exam successfully.',
            'data' => ExamQuestionResource::collection($exam->questions),
        ], 201);
    }

    public function destroy(Exam $exam, int $questionId)
    {
        $this->authorize('manageQuestions', $exam);

        $this->examQuestionService->detach($exam->id, $questionId);

        return response()->json([
            'status' => 'success',
            'message' => 'Question detached from exam successfully.',
            'data' => null,
        ]);
    }
}
