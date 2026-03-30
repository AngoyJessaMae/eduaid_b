<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'title',
        'content_text',
        'video_url',
        'material_path',
        'material_name',
        'curriculum_tag',
        'difficulty_level',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the subject this lesson belongs to.
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get all quizzes for this lesson.
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    /**
     * Get all student progress records for this lesson.
     */
    public function studentProgress()
    {
        return $this->hasMany(LessonProgress::class);
    }

    /**
     * Get all chat messages related to this lesson.
     */
    public function chatMessages()
    {
        return $this->hasMany(AIChatMessage::class);
    }
}
