<?php

namespace App\Http\Resources\Assessments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'attempt_id' => $this->id,
            'exam_id' => $this->exam_id,
            'status' => $this->status,
            'score' => $this->score,
            'percentage' => $this->percentage,
            'passed' => $this->passed,
            'started_at' => $this->started_at,
            'submitted_at' => $this->submitted_at,
        ];
    }
}
