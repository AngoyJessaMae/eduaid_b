<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Seed sample lessons for testing.
     */
    public function run(): void
    {
        // Math Lessons
        $mathSubject = Subject::where('name', 'Math')->first();
        if ($mathSubject) {
            Lesson::create([
                'subject_id' => $mathSubject->id,
                'title' => 'Introduction to Algebra',
                'content_text' => '<h2>What is Algebra?</h2><p>Algebra is a branch of mathematics that deals with symbols and the rules for manipulating these symbols. It involves solving equations and understanding variables.</p><h3>Key Concepts:</h3><ul><li>Variables: Letters that represent unknown numbers</li><li>Expressions: Combinations of variables and numbers</li><li>Equations: Statements that two expressions are equal</li></ul><p>Example: In the equation 2x + 5 = 15, x is a variable and we need to find its value.</p>',
                'difficulty_level' => 1,
                'is_active' => true,
            ]);

            Lesson::create([
                'subject_id' => $mathSubject->id,
                'title' => 'Geometry Basics',
                'content_text' => '<h2>Geometry Fundamentals</h2><p>Geometry is the study of shapes, sizes, and properties of figures and spaces.</p><h3>Basic Shapes:</h3><ul><li>Triangles: 3 sides</li><li>Rectangles: 4 sides with right angles</li><li>Circles: Round shapes with no corners</li></ul><h3>Important Formulas:</h3><p>Area of Rectangle = Length × Width</p><p>Area of Triangle = 1/2 × Base × Height</p><p>Circumference of Circle = 2πr</p>',
                'difficulty_level' => 2,
                'is_active' => true,
            ]);

            Lesson::create([
                'subject_id' => $mathSubject->id,
                'title' => 'Fractions and Decimals',
                'content_text' => '<h2>Understanding Fractions</h2><p>A fraction represents a part of a whole number.</p><h3>Fraction Basics:</h3><ul><li>Numerator: The top number</li><li>Denominator: The bottom number</li></ul><h3>Converting to Decimals:</h3><p>To convert a fraction to decimal, divide the numerator by the denominator.</p><p>Example: 3/4 = 0.75</p><h3>Working with Decimals:</h3><p>Decimals are another way to represent fractions using the base-10 system.</p>',
                'difficulty_level' => 2,
                'is_active' => true,
            ]);
        }

        // Science Lessons
        $scienceSubject = Subject::where('name', 'Science')->first();
        if ($scienceSubject) {
            Lesson::create([
                'subject_id' => $scienceSubject->id,
                'title' => 'The Human Body Systems',
                'content_text' => '<h2>Human Body Systems</h2><p>The human body is made up of several interconnected systems that work together to keep us alive and healthy.</p><h3>Major Systems:</h3><ul><li><strong>Circulatory System:</strong> Heart, blood, and blood vessels that transport oxygen</li><li><strong>Respiratory System:</strong> Lungs and airways for breathing</li><li><strong>Digestive System:</strong> Stomach and intestines that break down food</li><li><strong>Nervous System:</strong> Brain and nerves for communication</li><li><strong>Skeletal System:</strong> Bones that provide structure and support</li></ul><h3>How They Work:</h3><p>These systems depend on each other. For example, the respiratory system gets oxygen from air, the circulatory system delivers it to cells, and the digestive system provides nutrients.</p>',
                'difficulty_level' => 1,
                'is_active' => true,
            ]);

            Lesson::create([
                'subject_id' => $scienceSubject->id,
                'title' => 'Photosynthesis and Plant Life',
                'content_text' => '<h2>What is Photosynthesis?</h2><p>Photosynthesis is the process by which plants convert sunlight into chemical energy that can be used as fuel for growth.</p><h3>The Photosynthesis Equation:</h3><p>Carbon Dioxide + Water + Sunlight → Glucose + Oxygen</p><h3>Parts of a Plant:</h3><ul><li><strong>Roots:</strong> Absorb water and nutrients from soil</li><li><strong>Stem:</strong> Transports water and nutrients</li><li><strong>Leaves:</strong> Site of photosynthesis with chlorophyll</li><li><strong>Flowers:</strong> Reproductive organs</li></ul><h3>Why is Photosynthesis Important?</h3><p>It produces oxygen for us to breathe and glucose for the plant to use as energy. It\'s also the foundation of most food chains on Earth.</p>',
                'difficulty_level' => 2,
                'is_active' => true,
            ]);

            Lesson::create([
                'subject_id' => $scienceSubject->id,
                'title' => 'States of Matter',
                'content_text' => '<h2>States of Matter</h2><p>All matter on Earth exists in one of three states: solid, liquid, or gas.</p><h3>Solid:</h3><ul><li>Has a definite shape and volume</li><li>Particles are tightly packed and vibrate in place</li><li>Examples: Ice, rock, wood</li></ul><h3>Liquid:</h3><ul><li>Has a definite volume but takes the shape of its container</li><li>Particles are close together but can move</li><li>Examples: Water, oil, milk</li></ul><h3>Gas:</h3><ul><li>Has no definite shape or volume</li><li>Particles are spread far apart and move freely</li><li>Examples: Air, oxygen, carbon dioxide</li></ul><h3>Phase Changes:</h3><p>Melting (solid→liquid), Freezing (liquid→solid), Evaporation (liquid→gas), Condensation (gas→liquid)</p>',
                'difficulty_level' => 2,
                'is_active' => true,
            ]);
        }

        // English Lessons
        $englishSubject = Subject::where('name', 'English')->first();
        if ($englishSubject) {
            Lesson::create([
                'subject_id' => $englishSubject->id,
                'title' => 'Grammar Fundamentals',
                'content_text' => '<h2>Parts of Speech</h2><p>Understanding the parts of speech is fundamental to writing and speaking English correctly.</p><h3>The 8 Parts of Speech:</h3><ul><li><strong>Noun:</strong> A person, place, or thing (dog, school, happiness)</li><li><strong>Verb:</strong> An action or state of being (run, is, think)</li><li><strong>Adjective:</strong> A word that describes a noun (blue, happy, tall)</li><li><strong>Adverb:</strong> A word that describes a verb (quickly, very, well)</li><li><strong>Pronoun:</strong> A word that replaces a noun (he, she, it, they)</li><li><strong>Preposition:</strong> A word showing position or relationship (in, on, at, to)</li><li><strong>Conjunction:</strong> A word that connects (and, but, or, because)</li><li><strong>Interjection:</strong> An exclamation (oh, wow, hey)</li></ul><h3>Examples:</h3><p>"The quick brown fox jumps over the lazy dog."</p><ul><li>The = Article</li><li>quick, brown, lazy = Adjectives</li><li>fox, dog = Nouns</li><li>jumps = Verb</li><li>over = Preposition</li></ul>',
                'difficulty_level' => 1,
                'is_active' => true,
            ]);

            Lesson::create([
                'subject_id' => $englishSubject->id,
                'title' => 'Sentence Structure and Types',
                'content_text' => '<h2>Types of Sentences</h2><h3>Declarative Sentence:</h3><p>Makes a statement and ends with a period.</p><p>Example: "I am learning English."</p><h3>Interrogative Sentence:</h3><p>Asks a question and ends with a question mark.</p><p>Example: "Are you learning English?"</p><h3>Imperative Sentence:</h3><p>Gives a command and ends with a period or exclamation mark.</p><p>Example: "Learn English now!"</p><h3>Exclamatory Sentence:</h3><p>Expresses strong emotion and ends with an exclamation mark.</p><p>Example: "This is amazing!"</p><h3>Sentence Structure:</h3><ul><li><strong>Simple:</strong> One independent clause (subject + verb)</li><li><strong>Compound:</strong> Two independent clauses joined by a conjunction</li><li><strong>Complex:</strong> One independent clause and one or more dependent clauses</li><li><strong>Compound-Complex:</strong> Two or more independent clauses and one or more dependent clauses</li></ul>',
                'difficulty_level' => 2,
                'is_active' => true,
            ]);

            Lesson::create([
                'subject_id' => $englishSubject->id,
                'title' => 'Vocabulary Building',
                'content_text' => '<h2>Building Your Vocabulary</h2><h3>Context Clues:</h3><p>You can often understand new words by looking at the surrounding words and sentences.</p><h3>Word Families:</h3><p>Many words come from the same root word.</p><p>Example: Happy, happily, happiness, unhappy</p><h3>Synonyms and Antonyms:</h3><ul><li><strong>Synonyms:</strong> Words with similar meanings (big/large, happy/joyful)</li><li><strong>Antonyms:</strong> Words with opposite meanings (hot/cold, bright/dark)</li></ul><h3>Common Prefixes and Suffixes:</h3><ul><li>Prefix "un-" means not: unhappy, unclear</li><li>Prefix "re-" means again: redo, rewrite</li><li>Suffix "-ly" makes adverbs: quickly, happily</li><li>Suffix "-tion" makes nouns: action, creation</li></ul><h3>Tips for Learning Vocabulary:</h3><ol><li>Read widely and frequently</li><li>Use new words in sentences</li><li>Keep a vocabulary journal</li><li>Study words by category</li></ol>',
                'difficulty_level' => 1,
                'is_active' => true,
            ]);
        }
    }
}
