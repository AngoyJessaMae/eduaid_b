<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\LessonController as StudentLessonController;
use App\Http\Controllers\Student\PretestController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;
use App\Http\Controllers\Student\ReportController as StudentReportController;
use App\Http\Controllers\Student\TutorController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\LessonController as AdminLessonController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuestionController;
use Illuminate\Support\Facades\Route;

// Guest/unauthenticated routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user && $user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('student.dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Student routes
Route::middleware(['auth', 'verified', 'role:student'])->group(function () {
    Route::prefix('student')->name('student.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

        // Lessons
        Route::get('/lessons', [StudentLessonController::class, 'index'])->name('lessons.index');
        Route::get('/lessons/{lesson}', [StudentLessonController::class, 'show'])->name('lessons.show');
        Route::post('/lessons/{lesson}/complete', [StudentLessonController::class, 'complete'])->name('lessons.complete');

        // Quizzes
        Route::get('/quizzes', [StudentQuizController::class, 'index'])->name('quizzes.index');
        Route::get('/quizzes/{quiz}', [StudentQuizController::class, 'show'])->name('quizzes.show');
        Route::post('/quizzes/{quiz}/submit', [StudentQuizController::class, 'submit'])->name('quizzes.submit');

        // Reports
        Route::get('/reports', [StudentReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/print', [StudentReportController::class, 'print'])->name('reports.print');
        Route::get('/reports/download', [StudentReportController::class, 'download'])->name('reports.download');

        // Pretest
        Route::get('/pretest', [PretestController::class, 'index'])->name('pretest.index');
        Route::get('/pretest/{subject}/start', [PretestController::class, 'start'])->name('pretest.start');
        Route::post('/pretest/{subject}/submit', [PretestController::class, 'submit'])->name('pretest.submit');
        Route::get('/pretest/results/{attempt}', [PretestController::class, 'results'])->name('pretest.results');

        // AI Tutor
        Route::get('/tutor', [TutorController::class, 'index'])->name('tutor.index');
        Route::post('/tutor/send-message', [TutorController::class, 'sendMessage'])->name('tutor.send');
        Route::get('/tutor/history', [TutorController::class, 'getHistory'])->name('tutor.history');
    });
});

// Admin routes
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytics', [AdminDashboardController::class, 'analytics'])->name('analytics');

        // Subjects
        Route::resource('subjects', SubjectController::class);

        // Lessons
        Route::resource('lessons', AdminLessonController::class);
        Route::post('/lessons/{lesson}/toggle-active', [AdminLessonController::class, 'toggleActive'])->name('lessons.toggle-active');

        // Quizzes
        Route::resource('quizzes', QuizController::class);
        Route::post('/quizzes/{quiz}/toggle-active', [QuizController::class, 'toggleActive'])->name('quizzes.toggle-active');

        // Questions - Pretest
        Route::prefix('questions/pretest')->name('questions.pretest.')->group(function () {
            Route::get('/', [QuestionController::class, 'pretestIndex'])->name('index');
            Route::get('/create', [QuestionController::class, 'pretestCreate'])->name('create');
            Route::post('/', [QuestionController::class, 'pretestStore'])->name('store');
            Route::get('/{question}/edit', [QuestionController::class, 'pretestEdit'])->name('edit');
            Route::patch('/{question}', [QuestionController::class, 'pretestUpdate'])->name('update');
            Route::delete('/{question}', [QuestionController::class, 'pretestDestroy'])->name('destroy');
        });

        // Questions - Quiz
        Route::prefix('quizzes/{quiz}/questions')->name('questions.quiz.')->group(function () {
            Route::get('/', [QuestionController::class, 'quizIndex'])->name('index');
            Route::get('/create', [QuestionController::class, 'quizCreate'])->name('create');
            Route::post('/', [QuestionController::class, 'quizStore'])->name('store');
            Route::get('/{question}/edit', [QuestionController::class, 'quizEdit'])->name('edit');
            Route::patch('/{question}', [QuestionController::class, 'quizUpdate'])->name('update');
            Route::delete('/{question}', [QuestionController::class, 'quizDestroy'])->name('destroy');
        });
    });
});

require __DIR__.'/auth.php';
