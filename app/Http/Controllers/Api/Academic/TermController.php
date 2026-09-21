<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Academic\TermRequest;
use App\Interface\Api\Academic\TermInterface;
use App\Trait\ResponseTrait;
use Illuminate\Http\Request;

class TermController extends Controller
{
    use ResponseTrait;

    protected ?TermInterface $termService;

    public function __construct(TermInterface $termService)
    {
        $this->termService = $termService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = $this->termService->index();
        return $this->finalResponse($result);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TermRequest $request)
    {
        $result = $this->termService->store($request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->termService->show($id);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TermRequest $request, string $id)
    {
        $result = $this->termService->update($request->validated(), $id);
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->termService->destroy($id);
        return $this->finalResponse($result);
    }

    /**
     * Activate the specified resource.
     */
    public function activate(string $id)
    {
        $result = $this->termService->activate($id);
        return $this->finalResponse($result);
    }

    /**
     * Deactivate the specified resource.
     */
    public function deactivate(string $id)
    {
        $result = $this->termService->deactivate($id);
        return $this->finalResponse($result);
    }
}
