<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\QuizAttempt;
use App\Models\Subject;
use App\Models\Quiz;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * Display list of available lessons.
     */
    public function index()
    {
        $subjectFilter = request('subject');

        $lessons = Lesson::where('is_active', true)
            ->when($subjectFilter, fn ($query) => $query->where('subject_id', $subjectFilter))
            ->with([
                'subject',
                'quizzes',
                'studentProgress' => fn ($query) => $query->where('user_id', auth()->id()),
            ])
            ->paginate(12);

        $subjects = Subject::orderBy('name')->get();

        $userProgress = auth()->user()->lessonProgress()->pluck('completed', 'lesson_id');

        return view('student.lessons.index', [
            'lessons' => $lessons,
            'subjects' => $subjects,
            'userProgress' => $userProgress,
        ]);
    }

    /**
     * Display a specific lesson.
     */
    public function show(Lesson $lesson)
    {
        $user = auth()->user();

        // Get or create progress record
        $progress = LessonProgress::firstOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $lesson->id],
            ['completed' => false, 'quiz_score' => 0]
        );

        // Get associated quizzes
        $quizzes = $lesson->quizzes()->where('is_active', true)->withCount('questions')->get();

        // Get previous quiz attempts
        $quizAttempts = QuizAttempt::where('user_id', $user->id)
            ->whereIn('quiz_id', $quizzes->pluck('id'))
            ->with('quiz')
            ->latest()
            ->get();

        return view('student.lessons.show', [
            'lesson' => $lesson,
            'progress' => $progress,
            'quizzes' => $quizzes,
            'quizAttempts' => $quizAttempts,
        ]);
    }

    /**
     * Mark lesson as completed.
     */
    public function complete(Lesson $lesson)
    {
        $user = auth()->user();

        $progress = LessonProgress::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        if ($progress) {
            $progress->markCompleted();
        }

        return response()->json(['success' => true]);
    }
}
