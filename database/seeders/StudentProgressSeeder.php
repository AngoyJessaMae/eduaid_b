<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\PretestAnswer;
use App\Models\PretestAttempt;
use App\Models\PretestQuestion;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StudentProgressSeeder extends Seeder
{
    /**
     * Seed sample student progress data for testing reports.
     */
    public function run(): void
    {
        $student = User::where('email', 'test@example.com')->first();
        if (!$student) {
            return;
        }

        $subjects = Subject::all();

        foreach ($subjects as $subject) {
            // Create lesson progress
            $lessons = $subject->lessons()->take(3)->get();
            foreach ($lessons as $lesson) {
                $isCompleted = rand(0, 1);
                LessonProgress::create([
                    'user_id' => $student->id,
                    'lesson_id' => $lesson->id,
                    'completed' => $isCompleted,
                    'quiz_score' => rand(40, 100),
                    'completed_at' => $isCompleted ? Carbon::now()->subDays(rand(0, 4)) : null,
                ]);

                // Create quiz attempts for quizzes associated with this lesson
                $quizzes = $lesson->quizzes()->get();
                foreach ($quizzes as $quiz) {
                    $score = rand(40, 100);

                    QuizAttempt::create([
                        'user_id' => $student->id,
                        'quiz_id' => $quiz->id,
                        'overall_score' => $score,
                    ]);
                }
            }
        }
    }
}
