<?php

namespace App\Http\Controllers\Api\Assessments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Assessments\OptionRequest;
use App\Interface\Api\Assessments\OptionInterface;
use App\Trait\ResponseTrait;

class OptionController extends Controller
{
    use ResponseTrait;

    protected ?OptionInterface $optionService;

    public function __construct(OptionInterface $optionService)
    {
        $this->optionService = $optionService;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->optionService->getOptionById($id);
        return $this->finalResponse($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OptionRequest $request, string $id)
    {
        $result = $this->optionService->updateOption($id, $request->validated());
        return $this->finalResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = $this->optionService->deleteOption($id);
        return $this->finalResponse($result);
    }
}
