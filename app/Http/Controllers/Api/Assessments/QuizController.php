<?php

namespace App\Http\Controllers\Api\Assessments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Assessments\QuizRequest;
use App\Interface\Api\Assessments\QuizInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    use ResponseTrait;

    protected ?QuizInterface $quizService;

    public function __construct(QuizInterface $quizService)
    {
        $this->quizService = $quizService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->quizService->getAllQuizzes();
        return $this->finalResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuizRequest $request)
    {
        $result = $this->quizService->createQuiz($request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->quizService->getQuizById($id);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuizRequest $request, string $id)
    {
        $result = $this->quizService->updateQuiz($request->validated(), $id);
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->quizService->deleteQuiz($id);
        return $this->finalResponse($result);
    }
}
