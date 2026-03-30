<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'overall_score',
    ];

    /**
     * Get the user who attempted the quiz.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the quiz this attempt is for.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the lesson associated with this quiz attempt (through quiz).
     */
    public function lesson()
    {
        return $this->hasOneThrough(Lesson::class, Quiz::class, 'id', 'id', 'quiz_id', 'lesson_id');
    }
}
