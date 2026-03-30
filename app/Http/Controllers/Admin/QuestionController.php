<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PretestQuestion;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Subject;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display pretest questions.
     */
    public function pretestIndex()
    {
        $subjectId = request('subject');

        $questions = PretestQuestion::with('subject')
            ->when($subjectId, fn ($query) => $query->where('subject_id', $subjectId))
            ->paginate(20)
            ->withQueryString();

        $subjects = Subject::orderBy('name')->get();

        return view('admin.questions.pretest_index', [
            'questions' => $questions,
            'subjects' => $subjects,
        ]);
    }

    /**
     * Show form to create a new pretest question.
     */
    public function pretestCreate()
    {
        $subjects = Subject::all();

        return view('admin.questions.pretest_form', [
            'subjects' => $subjects,
        ]);
    }

    /**
     * Store a newly created pretest question.
     */
    public function pretestStore(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|integer|exists:subjects,id',
            'question' => 'required|string',
            'choices' => 'required|array|min:2',
            'choices.*' => 'required|string',
            'correct_answer' => 'required|string|in:' . implode(',', $request->input('choices', [])),
            'difficulty_weight' => 'required|integer|min:1|max:5',
        ]);

        $question = PretestQuestion::create([
            'subject_id' => $validated['subject_id'],
            'question' => $validated['question'],
            'choices' => $validated['choices'],
            'correct_answer' => $validated['correct_answer'],
            'difficulty_weight' => $validated['difficulty_weight'],
        ]);

        return redirect()->route('admin.questions.pretest.index')
            ->with('success', 'Pretest question created successfully.');
    }

    /**
     * Show form to edit a pretest question.
     */
    public function pretestEdit(PretestQuestion $question)
    {
        $subjects = Subject::all();

        return view('admin.questions.pretest_form', [
            'question' => $question,
            'subjects' => $subjects,
        ]);
    }

    /**
     * Update pretest question.
     */
    public function pretestUpdate(Request $request, PretestQuestion $question)
    {
        $validated = $request->validate([
            'subject_id' => 'required|integer|exists:subjects,id',
            'question' => 'required|string',
            'choices' => 'required|array|min:2',
            'choices.*' => 'required|string',
            'correct_answer' => 'required|string|in:' . implode(',', $request->input('choices', [])),
            'difficulty_weight' => 'required|integer|min:1|max:5',
        ]);

        $question->update([
            'subject_id' => $validated['subject_id'],
            'question' => $validated['question'],
            'choices' => $validated['choices'],
            'correct_answer' => $validated['correct_answer'],
            'difficulty_weight' => $validated['difficulty_weight'],
        ]);

        return redirect()->route('admin.questions.pretest.index')
            ->with('success', 'Pretest question updated successfully.');
    }

    /**
     * Delete pretest question.
     */
    public function pretestDestroy(PretestQuestion $question)
    {
        $question->delete();

        return redirect()->route('admin.questions.pretest.index')
            ->with('success', 'Pretest question deleted successfully.');
    }

    /** QUIZ QUESTIONS */

    /**
     * Display quiz questions for a quiz.
     */
    public function quizIndex(Quiz $quiz)
    {
        $questions = $quiz->questions()->paginate(20);

        return view('admin.questions.quiz_index', [
            'quiz' => $quiz,
            'questions' => $questions,
        ]);
    }

    /**
     * Show form to create a new quiz question.
     */
    public function quizCreate(Quiz $quiz)
    {
        return view('admin.questions.quiz_form', [
            'quiz' => $quiz,
        ]);
    }

    /**
     * Store a newly created quiz question.
     */
    public function quizStore(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'choices' => 'required|array|min:2',
            'choices.*' => 'required|string',
            'correct_answer' => 'required|string|in:' . implode(',', $request->input('choices', [])),
            'difficulty_weight' => 'required|integer|min:1|max:5',
        ]);

        $question = QuizQuestion::create([
            'quiz_id' => $quiz->id,
            'question' => $validated['question'],
            'choices' => $validated['choices'],
            'correct_answer' => $validated['correct_answer'],
            'difficulty_weight' => $validated['difficulty_weight'],
        ]);

        return redirect()->route('admin.questions.quiz.index', $quiz)
            ->with('success', 'Quiz question created successfully.');
    }

    /**
     * Show form to edit a quiz question.
     */
    public function quizEdit(Quiz $quiz, QuizQuestion $question)
    {
        return view('admin.questions.quiz_form', [
            'quiz' => $quiz,
            'question' => $question,
        ]);
    }

    /**
     * Update quiz question.
     */
    public function quizUpdate(Request $request, Quiz $quiz, QuizQuestion $question)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'choices' => 'required|array|min:2',
            'choices.*' => 'required|string',
            'correct_answer' => 'required|string|in:' . implode(',', $request->input('choices', [])),
            'difficulty_weight' => 'required|integer|min:1|max:5',
        ]);

        $question->update([
            'question' => $validated['question'],
            'choices' => $validated['choices'],
            'correct_answer' => $validated['correct_answer'],
            'difficulty_weight' => $validated['difficulty_weight'],
        ]);

        return redirect()->route('admin.questions.quiz.index', $quiz)
            ->with('success', 'Quiz question updated successfully.');
    }

    /**
     * Delete quiz question.
     */
    public function quizDestroy(Quiz $quiz, QuizQuestion $question)
    {
        $question->delete();

        return redirect()->route('admin.questions.quiz.index', $quiz)
            ->with('success', 'Quiz question deleted successfully.');
    }
}
