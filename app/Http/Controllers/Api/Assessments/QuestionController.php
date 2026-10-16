<?php

namespace App\Http\Controllers\Api\Assessments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Assessments\OptionRequest;
use App\Http\Requests\Assessments\QuestionRequest;
use App\Interface\Api\Assessments\QuestionInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    use ResponseTrait;

    protected ?QuestionInterface $questionService;

    public function __construct(QuestionInterface $questionService)
    {
        $this->questionService = $questionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->questionService->getAllQuestions();
        return $this->finalResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionRequest $request)
    {
        $result = $this->questionService->createQuestion($request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->questionService->getQuestionById($id);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionRequest $request, string $id)
    {
        $result = $this->questionService->updateQuestion($id, $request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->questionService->deleteQuestion($id);
        return $this->finalResponse($result);
    }

    /**
     * Get options for a specific question.
     */
    public function getOptions(string $id)
    {
        $result = $this->questionService->getOptionsByQuestionId($id);
        return $this->finalResponse($result);
    }

    /**
     * Add an option to a specific question.
     */
    public function addOption(OptionRequest $request, string $id)
    {
        $result = $this->questionService->addOptionToQuestion($id, $request->validated());
        return $this->finalResponse($result);
    }
}
