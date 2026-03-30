<?php

namespace Database\Seeders;

use App\Models\PretestQuestion;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class PretestContentSeeder extends Seeder
{
    /**
     * Seed pretest content for English, Math, and Science.
     */
    public function run(): void
    {
        $subjects = [
            'Math' => [
                [
                    'question' => 'What is the value of 8 + 15?',
                    'choices' => ['21', '22', '23', '24'],
                    'correct_answer' => '23',
                    'difficulty_weight' => 1,
                ],
                [
                    'question' => 'If x + 7 = 19, what is x?',
                    'choices' => ['10', '11', '12', '13'],
                    'correct_answer' => '12',
                    'difficulty_weight' => 1,
                ],
                [
                    'question' => 'What is the area of a rectangle with length 9 cm and width 4 cm?',
                    'choices' => ['13 sq cm', '26 sq cm', '36 sq cm', '45 sq cm'],
                    'correct_answer' => '36 sq cm',
                    'difficulty_weight' => 3,
                ],
                [
                    'question' => 'What is 3/4 expressed as a decimal?',
                    'choices' => ['0.25', '0.5', '0.75', '0.8'],
                    'correct_answer' => '0.75',
                    'difficulty_weight' => 3,
                ],
                [
                    'question' => 'Solve: 2x - 5 = 17',
                    'choices' => ['9', '10', '11', '12'],
                    'correct_answer' => '11',
                    'difficulty_weight' => 5,
                ],
            ],
            'Science' => [
                [
                    'question' => 'Which organ pumps blood throughout the body?',
                    'choices' => ['Lungs', 'Liver', 'Heart', 'Kidney'],
                    'correct_answer' => 'Heart',
                    'difficulty_weight' => 1,
                ],
                [
                    'question' => 'What is the process by which plants make their own food?',
                    'choices' => ['Respiration', 'Photosynthesis', 'Digestion', 'Evaporation'],
                    'correct_answer' => 'Photosynthesis',
                    'difficulty_weight' => 1,
                ],
                [
                    'question' => 'Which state of matter has a definite shape and volume?',
                    'choices' => ['Solid', 'Liquid', 'Gas', 'Plasma'],
                    'correct_answer' => 'Solid',
                    'difficulty_weight' => 3,
                ],
                [
                    'question' => 'What is the main gas found in Earth\'s atmosphere?',
                    'choices' => ['Oxygen', 'Carbon Dioxide', 'Nitrogen', 'Hydrogen'],
                    'correct_answer' => 'Nitrogen',
                    'difficulty_weight' => 3,
                ],
                [
                    'question' => 'Which part of the cell contains genetic material?',
                    'choices' => ['Cell membrane', 'Cytoplasm', 'Nucleus', 'Mitochondria'],
                    'correct_answer' => 'Nucleus',
                    'difficulty_weight' => 5,
                ],
            ],
            'English' => [
                [
                    'question' => 'Choose the correct sentence.',
                    'choices' => ['She go to school daily.', 'She goes to school daily.', 'She going to school daily.', 'She gone to school daily.'],
                    'correct_answer' => 'She goes to school daily.',
                    'difficulty_weight' => 1,
                ],
                [
                    'question' => 'What is the synonym of "happy"?',
                    'choices' => ['Sad', 'Joyful', 'Angry', 'Tired'],
                    'correct_answer' => 'Joyful',
                    'difficulty_weight' => 1,
                ],
                [
                    'question' => 'Identify the adjective in this sentence: "The bright sun warmed the field."',
                    'choices' => ['sun', 'warmed', 'bright', 'field'],
                    'correct_answer' => 'bright',
                    'difficulty_weight' => 3,
                ],
                [
                    'question' => 'Which punctuation mark should end a direct question?',
                    'choices' => ['Period', 'Comma', 'Exclamation point', 'Question mark'],
                    'correct_answer' => 'Question mark',
                    'difficulty_weight' => 3,
                ],
                [
                    'question' => 'Choose the best thesis statement for an essay about reading habits.',
                    'choices' => [
                        'Reading is fun.',
                        'People read books.',
                        'Developing a daily reading habit improves vocabulary, focus, and creativity.',
                        'Books are everywhere.',
                    ],
                    'correct_answer' => 'Developing a daily reading habit improves vocabulary, focus, and creativity.',
                    'difficulty_weight' => 5,
                ],
            ],
        ];

        foreach ($subjects as $subjectName => $questions) {
            $subject = Subject::firstOrCreate(['name' => $subjectName]);

            foreach ($questions as $item) {
                PretestQuestion::updateOrCreate(
                    [
                        'subject_id' => $subject->id,
                        'question' => $item['question'],
                    ],
                    [
                        'choices' => $item['choices'],
                        'correct_answer' => $item['correct_answer'],
                        'difficulty_weight' => $item['difficulty_weight'],
                    ]
                );
            }
        }
    }
}
