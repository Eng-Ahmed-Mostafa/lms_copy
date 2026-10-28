<?php

namespace App\Http\Resources\Api\Assessments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'question_text' => $this->question_text,
            'type' => $this->type,
            'points' => $this->pivot->options ?? $this->points,
            'options' => $this->options->map(fn ($option) => [
                'id' => $option->id,
                'option_text' => $option->option_text,
            ]),
        ];
    }
}
