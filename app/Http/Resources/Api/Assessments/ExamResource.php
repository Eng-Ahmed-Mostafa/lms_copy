<?php

namespace App\Http\Resources\Api\Assessments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
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
            'course_id' => $this->course_id,
            'title' => $this->title,
            'description' => $this->description,
            'duration' => $this->duration,
            'attempts_allowed' => $this->attempts_allowed,
            'passing_score' => $this->passing_score,
            'randomize_questions' => $this->randomize_questions,
            'show_correct_answers' => $this->show_correct_answers,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
            'total_points' => $this->total_points,
            'questions_count' => $this->questions_count,
            'course' => $this->whenLoaded('course', function () {
                return [
                    'id' => $this->course->id,
                    'title' => $this->course->title,
                ];
            }),
            'questions' => ExamQuestionResource::collection($this->whenLoaded('questions')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
