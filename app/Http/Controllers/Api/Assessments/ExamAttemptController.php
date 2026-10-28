<?php

namespace App\Http\Controllers\Api\Assessments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Assessments\SubmitExamAttemptRequest;
use App\Http\Requests\Assessments\Exam\SaveExamAnswersRequest;
use App\Http\Resources\Api\Assessments\ExamQuestionResource;
use App\Http\Resources\Assessments\ExamAttemptResource;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Services\Assessments\ExamAnswerService;
use App\Services\Assessments\ExamAttemptService;
use App\Services\Assessments\ExamGradingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class ExamAttemptController extends Controller
{
    public function __construct(
        private ExamAttemptService $examAttemptService,
        private ExamAnswerService  $examAnswerService,
        private ExamGradingService  $examGradingService,
    ) {}

    public function show(ExamAttempt $attempt, Request $request): ExamAttemptResource
    {
        $user = $request->user();

        $student = $user->student;

        $ownsAttempt = $student !== null && (int) $attempt->student_id === (int) $student->id;

        if (!$ownsAttempt) {
            Gate::authorize('viewStatistics', $attempt->exam);
        }

        return new ExamAttemptResource($attempt);
    }

    public function submit(SubmitExamAttemptRequest $request, ExamAttempt $attempt)
    {
        Gate::authorize('submit', $attempt);
        $attempt = $this->examAttemptService->submit($attempt->id, $request->user(), $request->validated()['answers'] ?? []);

        return response()->json([
            'status' => 'success',
            'message' => 'Exam attempt submitted successfully.',
            'data' => new ExamAttemptResource($attempt),
        ]);
    }

    public function getAnswers(int $id): ExamAttemptResource
    {
        $attempt = $this->examAttemptService->findById($id);

        Gate::authorize('view', $attempt);

        return new ExamAttemptResource($attempt);
    }

    public function saveAnswers(SaveExamAnswersRequest $request, int $id): ExamAttemptResource
    {
        $attempt = $this->examAttemptService->findById($id);

        Gate::authorize('update', $attempt);

        $updatedAttempt = $this->examAnswerService->saveAnswer($attempt, $request->validated()['answers'] ?? []);

        return new ExamAttemptResource($updatedAttempt);
    }

    public function getResults(int $id): ExamAttemptResource
    {
        $attempt = $this->examAttemptService->findById($id);

        Gate::authorize('view', $attempt);

        if ($attempt->status !== 'submitted') {
            throw ValidationException::withMessages([
                'result' => 'The result is not available until the exam attempt is submitted.',
            ]);
        }

        return new ExamAttemptResource($attempt);
    }

    public function start(Exam $exam, Request $request)
    {
        $this->authorize('view', $exam);

        $result = $this->examAttemptService->start($exam->id, $request->user());

        return response()->json([
            'status' => 'success',
            'message' => 'Exam attempt started successfully.',
            'data' => [
                'attempt' => new ExamAttemptResource($result['attempt']),
                'exam' => [
                    'id' => $result['exam']->id,
                    'title' => $result['exam']->title,
                    'duration' => $result['duration'],
                    'started_at' => $result['started_at'],
                    'expires_at' => $result['expires_at'],
                    'questions' => ExamQuestionResource::collection($result['exam']->questions),
                ]
            ],
        ], 201);
    }
}
