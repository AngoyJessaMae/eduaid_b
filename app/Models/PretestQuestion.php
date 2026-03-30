<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PretestQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'question',
        'choices',
        'correct_answer',
        'difficulty_weight',
    ];

    protected $casts = [
        'choices' => 'json',
    ];

    /**
     * Get the subject this question belongs to.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get all answers to this question.
     */
    public function answers()
    {
        return $this->hasMany(PretestAnswer::class);
    }
}
