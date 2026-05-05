<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\LessonController as StudentLessonController;
use App\Http\Controllers\Student\PretestController;
use App\Http\Controllers\Student\QuizController as StudentQuizController;
use App\Http\Controllers\Student\ReportController as StudentReportController;
use App\Http\Controllers\Student\TutorController;
use Illuminate\Support\Facades\Route;

// Guest/unauthenticated routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
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



require __DIR__.'/auth.php';
