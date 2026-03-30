<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PretestAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'overall_score',
        'math_score',
        'science_score',
        'english_score',
        'math_level',
        'science_level',
        'english_level',
    ];

    /**
     * Get the user who attempted the pretest.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all answers for this pretest attempt.
     */
    public function answers()
    {
        return $this->hasMany(PretestAnswer::class);
    }

    /**
     * Get the latest pretest attempt for a user.
     */
    public static function latestForUser($userId)
    {
        return self::where('user_id', $userId)->latest()->first();
    }
}
