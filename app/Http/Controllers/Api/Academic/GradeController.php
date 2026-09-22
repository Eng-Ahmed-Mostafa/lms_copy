<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\GradeRequest;
use App\Interface\Api\Academic\GradeInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    use ResponseTrait;

    protected ?GradeInterface $gradeService;

    public function __construct(GradeInterface $gradeService)
    {
        $this->gradeService = $gradeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->gradeService->index();
        return $this->finalResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GradeRequest $request)
    {
        $result = $this->gradeService->store($request->all());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $result = $this->gradeService->show($slug);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GradeRequest $request, string $slug)
    {
        $result = $this->gradeService->update($request->all(), $slug);
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $result = $this->gradeService->destroy($slug);
        return $this->finalResponse($result);
    }
}
