<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display list of all quizzes.
     */
    public function index()
    {
        $quizzes = Quiz::with('lesson.subject')->paginate(20);

        return view('admin.quizzes.index', [
            'quizzes' => $quizzes,
        ]);
    }

    /**
     * Show form to create a new quiz.
     */
    public function create()
    {
        $lessons = Lesson::with('subject')->get();

        return view('admin.quizzes.form', [
            'lessons' => $lessons,
        ]);
    }

    /**
     * Store a newly created quiz.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'lesson_id' => 'required|integer|exists:lessons,id',
            'title' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $quiz = Quiz::create($validated);

        return redirect()->route('admin.quizzes.show', $quiz)
            ->with('success', 'Quiz created successfully.');
    }

    /**
     * Display the quiz details.
     */
    public function show(Quiz $quiz)
    {
        $quiz->load(['lesson.subject', 'questions', 'attempts']);

        return view('admin.quizzes.show', [
            'quiz' => $quiz,
        ]);
    }

    /**
     * Show form to edit the quiz.
     */
    public function edit(Quiz $quiz)
    {
        $lessons = Lesson::with('subject')->get();

        return view('admin.quizzes.form', [
            'quiz' => $quiz,
            'lessons' => $lessons,
        ]);
    }

    /**
     * Update the quiz.
     */
    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'lesson_id' => 'required|integer|exists:lessons,id',
            'title' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $quiz->update($validated);

        return redirect()->route('admin.quizzes.show', $quiz)
            ->with('success', 'Quiz updated successfully.');
    }

    /**
     * Delete the quiz.
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('admin.quizzes.index')
            ->with('success', 'Quiz deleted successfully.');
    }

    /**
     * Toggle quiz active status.
     */
    public function toggleActive(Quiz $quiz)
    {
        $quiz->is_active = !$quiz->is_active;
        $quiz->save();

        return response()->json([
            'success' => true,
            'is_active' => $quiz->is_active,
        ]);
    }
}
