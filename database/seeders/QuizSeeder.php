<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Seed sample quizzes for testing.
     */
    public function run(): void
    {
        // Math Quizzes
        $mathLessons = Lesson::whereHas('subject', function ($q) {
            $q->where('name', 'Math');
        })->take(2)->get();

        foreach ($mathLessons as $index => $lesson) {
            $quiz = Quiz::create([
                'lesson_id' => $lesson->id,
                'title' => $lesson->title . ' Quiz',
                'is_active' => true,
            ]);

            // Add questions for each quiz
            if ($index === 0) {
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'Solve: x + 8 = 15',
                    'choices' => json_encode(['5', '7', '9', '23']),
                    'correct_answer' => '7',
                    'difficulty_weight' => 1,
                ]);

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'What is the value of 2x when x = 10?',
                    'choices' => json_encode(['5', '10', '20', '40']),
                    'correct_answer' => '20',
                    'difficulty_weight' => 1,
                ]);

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'Simplify: 3x + 2x',
                    'choices' => json_encode(['5x', '6x', '5x²', 'x']),
                    'correct_answer' => '5x',
                    'difficulty_weight' => 3,
                ]);

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'If 2x - 4 = 10, what is x?',
                    'choices' => json_encode(['3', '5', '7', '14']),
                    'correct_answer' => '7',
                    'difficulty_weight' => 3,
                ]);

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'Solve: 3(x + 2) = 21',
                    'choices' => json_encode(['5', '7', '9', '11']),
                    'correct_answer' => '5',
                    'difficulty_weight' => 5,
                ]);
            } else {
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'What is the area of a square with side 5 cm?',
                    'choices' => json_encode(['10 sq cm', '15 sq cm', '20 sq cm', '25 sq cm']),
                    'correct_answer' => '25 sq cm',
                    'difficulty_weight' => 1,
                ]);

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'A triangle has angles of 60°, 60°, and ?',
                    'choices' => json_encode(['40°', '50°', '60°', '70°']),
                    'correct_answer' => '60°',
                    'difficulty_weight' => 1,
                ]);

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'What is the perimeter of a rectangle with length 8 and width 4?',
                    'choices' => json_encode(['12', '24', '32', '48']),
                    'correct_answer' => '24',
                    'difficulty_weight' => 3,
                ]);
            }
        }

        // Science Quizzes
        $scienceLessons = Lesson::whereHas('subject', function ($q) {
            $q->where('name', 'Science');
        })->take(2)->get();

        foreach ($scienceLessons as $index => $lesson) {
            $quiz = Quiz::create([
                'lesson_id' => $lesson->id,
                'title' => $lesson->title . ' Quiz',
                'is_active' => true,
            ]);

            if ($index === 0) {
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'Which organ filters waste from blood?',
                    'choices' => json_encode(['Liver', 'Kidney', 'Pancreas', 'Spleen']),
                    'correct_answer' => 'Kidney',
                    'difficulty_weight' => 1,
                ]);

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'What is the function of white blood cells?',
                    'choices' => json_encode(['Transport oxygen', 'Fight infections', 'Carry nutrients', 'Store energy']),
                    'correct_answer' => 'Fight infections',
                    'difficulty_weight' => 3,
                ]);

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'How many chambers does a human heart have?',
                    'choices' => json_encode(['2', '3', '4', '6']),
                    'correct_answer' => '4',
                    'difficulty_weight' => 1,
                ]);

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'Which part of the brain controls balance and coordination?',
                    'choices' => json_encode(['Cerebrum', 'Cerebellum', 'Brainstem', 'Thalamus']),
                    'correct_answer' => 'Cerebellum',
                    'difficulty_weight' => 5,
                ]);
            } else {
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'What color is chlorophyll?',
                    'choices' => json_encode(['Yellow', 'Red', 'Green', 'Blue']),
                    'correct_answer' => 'Green',
                    'difficulty_weight' => 1,
                ]);

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'Which organelle is responsible for photosynthesis?',
                    'choices' => json_encode(['Mitochondria', 'Chloroplast', 'Nucleus', 'Ribosome']),
                    'correct_answer' => 'Chloroplast',
                    'difficulty_weight' => 3,
                ]);

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'What gas do plants release during photosynthesis?',
                    'choices' => json_encode(['Nitrogen', 'Carbon dioxide', 'Oxygen', 'Hydrogen']),
                    'correct_answer' => 'Oxygen',
                    'difficulty_weight' => 1,
                ]);
            }
        }

        // English Quizzes
        $englishLessons = Lesson::whereHas('subject', function ($q) {
            $q->where('name', 'English');
        })->take(2)->get();

        foreach ($englishLessons as $index => $lesson) {
            $quiz = Quiz::create([
                'lesson_id' => $lesson->id,
                'title' => $lesson->title . ' Quiz',
                'is_active' => true,
            ]);

            if ($index === 0) {
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'Which word is a verb in this sentence: "The cat runs quickly"?',
                    'choices' => json_encode(['cat', 'runs', 'quickly', 'the']),
                    'correct_answer' => 'runs',
                    'difficulty_weight' => 1,
                ]);

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'Choose the correct sentence:',
                    'choices' => json_encode(['He go to school daily', 'He goes to school daily', 'He going to school daily', 'He gone to school daily']),
                    'correct_answer' => 'He goes to school daily',
                    'difficulty_weight' => 1,
                ]);

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'What is the tense of this sentence: "She has completed her work"?',
                    'choices' => json_encode(['Present', 'Past', 'Present Perfect', 'Future']),
                    'correct_answer' => 'Present Perfect',
                    'difficulty_weight' => 3,
                ]);

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'Which sentence has correct punctuation?',
                    'choices' => json_encode(['Its a beautiful day', 'Its a beautiful day.', "It\'s a beautiful day.", "Its a beautiful day,"]),
                    'correct_answer' => "It\'s a beautiful day.",
                    'difficulty_weight' => 3,
                ]);
            } else {
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'What is a synonym for "beautiful"?',
                    'choices' => json_encode(['Ugly', 'Lovely', 'Boring', 'Dark']),
                    'correct_answer' => 'Lovely',
                    'difficulty_weight' => 1,
                ]);

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'What is an antonym for "happy"?',
                    'choices' => json_encode(['Joyful', 'Sad', 'Excited', 'Content']),
                    'correct_answer' => 'Sad',
                    'difficulty_weight' => 1,
                ]);

                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => 'The word "benevolent" means:',
                    'choices' => json_encode(['Evil', 'Kind and generous', 'Intelligent', 'Brave']),
                    'correct_answer' => 'Kind and generous',
                    'difficulty_weight' => 3,
                ]);
            }
        }
    }
}
