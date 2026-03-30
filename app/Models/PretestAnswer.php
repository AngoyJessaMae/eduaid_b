<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PretestAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'pretest_attempt_id',
        'pretest_question_id',
        'selected_answer',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    /**
     * Get the pretest attempt this answer belongs to.
     */
    public function attempt()
    {
        return $this->belongsTo(PretestAttempt::class, 'pretest_attempt_id');
    }

    /**
     * Get the question this answer responds to.
     */
    public function question()
    {
        return $this->belongsTo(PretestQuestion::class, 'pretest_question_id');
    }
}
