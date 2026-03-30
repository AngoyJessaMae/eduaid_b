<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get all lessons for this subject.
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    /**
     * Get all pretest questions for this subject.
     */
    public function pretestQuestions()
    {
        return $this->hasMany(PretestQuestion::class);
    }
}
