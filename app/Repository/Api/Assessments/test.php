<?php

namespace App\Repository\Api\Assessments;

use App\Interface\Api\Assessments\ExamInterface;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Trait\RepositoryTrait;
use Illuminate\Support\Facades\Auth;

class ExamRepository implements ExamInterface
{
    use RepositoryTrait;

    // get all exams
    public function index()
    {
        $exams = Exam::with('course', 'questions')
            ->orderBy('created_at', 'desc')
            ->get();
        return $this->returnData(true, 'Exams retrieved successfully', 200, $exams);
    }

    // create a new exam
    public function create(array $data)
    {
        $exam = Exam::create([
            'course_id' => $data['course_id'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'duration' => $data['duration'],
            'attempts_allowed' => $data['attempts_allowed'],
            'passing_score' => $data['passing_score'],
            'randomize_questions' => $data['randomize_questions'],
            'show_correct_answers' => $data['show_correct_answers'],
        ]);
        return $this->returnData(true, 'Exam created successfully', 201, $exam);
    }

    // get a specific exam
    public function show(string $id)
    {
        $exam = Exam::with('course', 'questions')->find($id);
        if (!$exam) {
            return $this->returnData(false, 'Exam not found', 404);
        }
        return $this->returnData(true, 'Exam retrieved successfully', 200, $exam);
    }

    // update a specific exam
    public function update(array $data, string $id)
    {
        $exam = Exam::find($id);
        if (!$exam) {
            return $this->returnData(false, 'Exam not found', 404);
        }
        $exam->update([
            'course_id' => $data['course_id'],
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'duration' => $data['duration'],
            'attempts_allowed' => $data['attempts_allowed'],
            'passing_score' => $data['passing_score'],
            'randomize_questions' => $data['randomize_questions'],
            'show_correct_answers' => $data['show_correct_answers'],
        ]);
        return $this->returnData(true, 'Exam updated successfully', 200, $exam);
    }

    // delete a specific exam
    public function destroy(string $id)
    {
        $exam = Exam::find($id);
        if (!$exam) {
            return $this->returnData(false, 'Exam not found', 404);
        }
        $exam->delete();
        return $this->returnData(true, 'Exam deleted successfully', 200);
    }

    // get questions for a specific exam
    public function getExamQuestions(string $id)
    {
        $exam = Exam::with('questions')->find($id);
        if (!$exam) {
            return $this->returnData(false, 'Exam not found', 404);
        }
        $questions = $exam->questions;
        return $this->returnData(true, 'Exam questions retrieved successfully', 200, $questions);
    }

    // add a question to a specific exam
    public function addExamQuestion(array $data, string $id)
    {
        $exam = Exam::find($id);
        if (!$exam) {
            return $this->returnData(false, 'Exam not found', 404);
        }
        $exam->questions()->attach($data['question_id'], [
            'order' => $data['order'],
            'points' => $data['points'],
        ]);
        return $this->returnData(true, 'Question added to exam successfully', 200);
    }

    // remove a question from a specific exam
    public function removeExamQuestion(string $id, string $questionId)
    {
        $exam = Exam::find($id);
        if (!$exam) {
            return $this->returnData(false, 'Exam not found', 404);
        }
        $exam->questions()->detach($questionId);
        return $this->returnData(true, 'Question removed from exam successfully', 200);
    }

    // start a specific exam
    public function start(string $id)
    {
        $exam = Exam::find($id);
        if (!$exam) {
            return $this->returnData(false, 'Exam not found', 404);
        }

        $studentId = Auth::id();

        $attemptCount = ExamAttempt::where('exam_id', $exam->id)
            ->where('student_id', $studentId)
            ->count();

        if ($attemptCount >= $exam->attempts_allowed) {
            return $this->returnData(false, 'You have reached the maximum number of attempts for this exam', 400);
        }

        $attempt = ExamAttempt::create([
            'exam_id' => $exam->id,
            'student_id' => $studentId,
            'attempt_number' => $attemptCount + 1,
            'started_at' => now(),
            'status' => 'in_progress',
        ]);

        $data = [
            'exam' => $exam,
            'attempt' => $attempt,
        ];

        return $this->returnData(true, 'Exam started successfully', 200, $data);
    }

    // submit a specific exam
    public function submit($request, string $id)
    {
        $exam = Exam::find($id);
        if (!$exam) {
            return $this->returnData(false, 'Exam not found', 404);
        }

        ExamAttempt::where('exam_id', $exam->id)
            ->where('student_id', Auth::id())
            ->update([
                'submitted_at' => now(),
                'status' => 'submitted',
            ]);

        $exam->status = 'completed';
        $exam->save();
        return $this->returnData(true, 'Exam submitted successfully', 200, $exam);
    }

    // get statistics for a specific exam
    public function getExamStatistics(string $id)
    {
        $exam = Exam::with('questions')->find($id);
        if (!$exam) {
            return $this->returnData(false, 'Exam not found', 404);
        }
        $statistics = [
            'total_questions' => $exam->questions->count(),
            'total_points' => $exam->questions->sum('pivot.points'),
            'average_score' => $exam->questions->avg('pivot.points'),
        ];
        return $this->returnData(true, 'Exam statistics retrieved successfully', 200, $statistics);
    }
}
