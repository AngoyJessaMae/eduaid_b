<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question',
        'choices',
        'correct_answer',
        'difficulty_weight',
    ];

    protected $casts = [
        'choices' => 'json',
    ];

    /**
     * Get the quiz this question belongs to.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
