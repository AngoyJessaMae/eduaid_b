<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Progress Report</title>
    @vite(['resources/css/app.css'])
</head>
<body class="font-poppins bg-white text-gray-900 p-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between border-b pb-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold">{{ config('app.name', 'EduAid') }} Academic Progress Report</h1>
                <p class="text-sm text-gray-600">Generated on {{ now()->format('F d, Y h:i A') }}</p>
            </div>
            <button onclick="window.print()" class="btn-primary print:hidden">Print</button>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="kpi-card"><p class="text-sm text-gray-500">Lessons Completed</p><p class="text-3xl font-bold text-primary-700">{{ $lessonCompletedCount }}</p></div>
            <div class="kpi-card"><p class="text-sm text-gray-500">Average Quiz Score</p><p class="text-3xl font-bold text-accent-700">{{ $averageQuizScore }}%</p></div>
        </div>

        <div class="panel p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Diagnostic Proficiency Levels</h2>
            @if($pretestAttempt)
                <div class="grid grid-cols-3 gap-4 text-sm">
                    <div><p class="text-gray-500">Math</p><p class="font-semibold">{{ $pretestAttempt->math_level }}</p></div>
                    <div><p class="text-gray-500">Science</p><p class="font-semibold">{{ $pretestAttempt->science_level }}</p></div>
                    <div><p class="text-gray-500">English</p><p class="font-semibold">{{ $pretestAttempt->english_level }}</p></div>
                </div>
            @else
                <p class="text-gray-600">No diagnostic attempt available.</p>
            @endif
        </div>

        <div class="panel p-6">
            <h2 class="text-xl font-bold mb-4">Quiz Attempt History</h2>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b text-left">
                        <th class="py-2">Quiz</th>
                        <th class="py-2">Subject</th>
                        <th class="py-2">Score</th>
                        <th class="py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quizAttempts as $attempt)
                        <tr class="border-b">
                            <td class="py-2">{{ $attempt->quiz->title }}</td>
                            <td class="py-2">{{ $attempt->quiz->lesson->subject->name }}</td>
                            <td class="py-2 font-semibold">{{ $attempt->overall_score }}%</td>
                            <td class="py-2">{{ $attempt->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="py-2 text-gray-600">No quiz attempts yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
