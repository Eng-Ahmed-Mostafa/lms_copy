<?php

namespace App\Http\Resources\Assessments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamAttemptResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isSubmitted = $this->status === 'submitted';
        return [
            'id' => $this->id,
            'exam_id' => $this->exam_id,
            'student_id' => $this->student_id,
            'status' => $this->status,
            'started_at' => $this->started_at,
            'submitted_at' => $this->submitted_at,
            'score' => $isSubmitted ? $this->score : null,
            'exam' => $this->whenLoaded('exam', function () {
                return [
                    'id' => $this->exam->id,
                    'title' => $this->exam->title,
                    'duration' => $this->exam->duration,
                ];
            }),
            'answers' => $this->whenLoaded('examAnswers', function () use ($isSubmitted) {
                return $this->examAnswers->map(function ($answer) use ($isSubmitted) {
                    return [
                        'id' => $answer->id,
                        'question_id' => $answer->question,
                        'question_option_id' => $answer->question_option_id,
                        'question' => $answer->question_option_id ? [
                            'id' => $answer->question->id,
                            'text' => $answer->question->text,
                        ] : null,
                        'option' => $answer->option ? [
                            'id' => $answer->option->id,
                            'text' => $answer->option->option_text,
                        ] : null,
                        'is_correct' => $isSubmitted ? $answer->is_correct : null,
                        'points_earned' => $isSubmitted ? $answer->points_earned : null
                    ];
                });
            }),
            'result' => $isSubmitted ? [
                'score' => $this->score,
                'percentage' => $this->percentage,
                'passed' => $this->passed,
            ] : null,
            
        ];
    }
}
