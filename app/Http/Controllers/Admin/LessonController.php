<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    /**
     * Display list of all lessons.
     */
    public function index()
    {
        $lessons = Lesson::with('subject')->paginate(20);

        return view('admin.lessons.index', [
            'lessons' => $lessons,
        ]);
    }

    /**
     * Show form to create a new lesson.
     */
    public function create()
    {
        $subjects = Subject::all();

        return view('admin.lessons.form', [
            'subjects' => $subjects,
        ]);
    }

    /**
     * Store a newly created lesson.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|integer|exists:subjects,id',
            'title' => 'required|string|max:255',
            'content_text' => 'required|string',
            'video_url' => 'nullable|url',
            'material_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:15360',
            'curriculum_tag' => 'nullable|string|max:255',
            'difficulty_level' => 'required|in:Beginner,Intermediate,Advanced',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('material_file')) {
            $file = $request->file('material_file');
            $validated['material_path'] = $file->store('materials', 'public');
            $validated['material_name'] = $file->getClientOriginalName();
        }

        $lesson = Lesson::create($validated);

        return redirect()->route('admin.lessons.show', $lesson)
            ->with('success', 'Lesson created successfully.');
    }

    /**
     * Display the lesson details.
     */
    public function show(Lesson $lesson)
    {
        $lesson->load(['subject', 'quizzes']);

        return view('admin.lessons.show', [
            'lesson' => $lesson,
        ]);
    }

    /**
     * Show form to edit the lesson.
     */
    public function edit(Lesson $lesson)
    {
        $subjects = Subject::all();

        return view('admin.lessons.form', [
            'lesson' => $lesson,
            'subjects' => $subjects,
        ]);
    }

    /**
     * Update the lesson.
     */
    public function update(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'subject_id' => 'required|integer|exists:subjects,id',
            'title' => 'required|string|max:255',
            'content_text' => 'required|string',
            'video_url' => 'nullable|url',
            'material_file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:15360',
            'curriculum_tag' => 'nullable|string|max:255',
            'difficulty_level' => 'required|in:Beginner,Intermediate,Advanced',
            'is_active' => 'boolean',
        ]);

        if ($request->boolean('remove_material')) {
            if ($lesson->material_path) {
                Storage::disk('public')->delete($lesson->material_path);
            }
            $validated['material_path'] = null;
            $validated['material_name'] = null;
        }

        if ($request->hasFile('material_file')) {
            if ($lesson->material_path) {
                Storage::disk('public')->delete($lesson->material_path);
            }

            $file = $request->file('material_file');
            $validated['material_path'] = $file->store('materials', 'public');
            $validated['material_name'] = $file->getClientOriginalName();
        }

        $lesson->update($validated);

        return redirect()->route('admin.lessons.show', $lesson)
            ->with('success', 'Lesson updated successfully.');
    }

    /**
     * Delete the lesson.
     */
    public function destroy(Lesson $lesson)
    {
        if ($lesson->material_path) {
            Storage::disk('public')->delete($lesson->material_path);
        }

        $lesson->delete();

        return redirect()->route('admin.lessons.index')
            ->with('success', 'Lesson deleted successfully.');
    }

    /**
     * Toggle lesson active status.
     */
    public function toggleActive(Lesson $lesson)
    {
        $lesson->is_active = !$lesson->is_active;
        $lesson->save();

        return response()->json([
            'success' => true,
            'is_active' => $lesson->is_active,
        ]);
    }
}
