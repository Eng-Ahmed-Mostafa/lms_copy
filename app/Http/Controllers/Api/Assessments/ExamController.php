<?php

namespace App\Http\Controllers\Api\Assessments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Assessments\ExamQuestionRequest;
use App\Http\Requests\Assessments\ExamRequest;
use App\Interface\Api\Assessments\ExamInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    use ResponseTrait;

    private ?ExamInterface $examService;

    public function __construct(ExamInterface $examService)
    {
        $this->examService = $examService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = $this->examService->index();
        return $this->finalResponse($results);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExamRequest $request)
    {
        $results = $this->examService->create($request->validated());
        return $this->finalResponse($results);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $results = $this->examService->show($id);
        return $this->finalResponse($results);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExamRequest $request, string $id)
    {
        $results = $this->examService->update($request->validated(), $id);
        return $this->finalResponse($results);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $results = $this->examService->destroy($id);
        return $this->finalResponse($results);
    }

    /**
     * Get the questions for a specific exam.
     */
    public function getExamQuestions(string $id)
    {
        $results = $this->examService->getExamQuestions($id);
        return $this->finalResponse($results);
    }

    /**
     * Add a question to a specific exam.
     */
    public function addExamQuestion(ExamQuestionRequest $request, string $id)
    {
        $results = $this->examService->addExamQuestion($request->validated(), $id);
        return $this->finalResponse($results);
    }

    /**
     * Remove a question from a specific exam.
     */
    public function removeExamQuestion(string $id, string $questionId)
    {
        $results = $this->examService->removeExamQuestion($id, $questionId);
        return $this->finalResponse($results);
    }


    /**
     * Start a specific exam.
     */
    public function startExam(string $id)
    {
        $results = $this->examService->start($id);
        return $this->finalResponse($results);
    }

    /**
     * Submit a specific exam.
     */
    public function submitExam(Request $request, string $id)
    {
        $results = $this->examService->submit($request, $id);
        return $this->finalResponse($results);
    }

    /**
     * Get the statistics for a specific exam.
     */
    public function getExamStatistics(string $id)
    {
        $results = $this->examService->getExamStatistics($id);
        return $this->finalResponse($results);
    }
}
