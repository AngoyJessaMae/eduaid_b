<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display list of all subjects.
     */
    public function index()
    {
        $subjects = Subject::withCount(['lessons', 'pretestQuestions'])->paginate(20);

        return view('admin.subjects.index', [
            'subjects' => $subjects,
        ]);
    }

    /**
     * Show form to create a new subject.
     */
    public function create()
    {
        return view('admin.subjects.form');
    }

    /**
     * Store a newly created subject.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name',
        ]);

        $subject = Subject::create($validated);

        return redirect()->route('admin.subjects.show', $subject)
            ->with('success', 'Subject created successfully.');
    }

    /**
     * Display the subject details.
     */
    public function show(Subject $subject)
    {
        $subject->load(['lessons', 'pretestQuestions']);

        return view('admin.subjects.show', [
            'subject' => $subject,
        ]);
    }

    /**
     * Show form to edit the subject.
     */
    public function edit(Subject $subject)
    {
        return view('admin.subjects.form', [
            'subject' => $subject,
        ]);
    }

    /**
     * Update the subject.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id,
        ]);

        $subject->update($validated);

        return redirect()->route('admin.subjects.show', $subject)
            ->with('success', 'Subject updated successfully.');
    }

    /**
     * Delete the subject.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }
}
