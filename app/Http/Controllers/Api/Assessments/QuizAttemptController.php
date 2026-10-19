<?php

namespace App\Http\Controllers\Api\Assessments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Assessments\QuizAnswerRequest;
use App\Interface\Api\Assessments\QuizAttemptInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class QuizAttemptController extends Controller
{
    use ResponseTrait;

    protected ?QuizAttemptInterface $quizAttemptService;

    public function __construct(QuizAttemptInterface $quizAttemptService)
    {
        $this->quizAttemptService = $quizAttemptService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->quizAttemptService->getAllQuizAttempts();
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->quizAttemptService->getQuizAttemptById($id);
        return $this->finalResponse($result);
    }

    /**
     * Submit a quiz attempt.
     */
    public function submit(string $id)
    {
        $result = $this->quizAttemptService->submitQuizAttempt($id);
        return $this->finalResponse($result);
    }

    /**
     * Get answers for a specific quiz attempt.
     */
    public function getAnswers(string $id)
    {
        $result = $this->quizAttemptService->getQuizAnswers($id);
        return $this->finalResponse($result);
    }

    /**
     * Submit an answer for a specific quiz attempt.
     */
    public function submitAnswer(QuizAnswerRequest $request,string $id)
    {
        $result = $this->quizAttemptService->submitQuizAnswer($request->validated(), $id);
        return $this->finalResponse($result);
    }

    /**
     * Get the result of a specific quiz attempt.
     */
    public function getResult(string $id)
    {
        $result = $this->quizAttemptService->getQuizResult($id);
        return $this->finalResponse($result);
    }
}
