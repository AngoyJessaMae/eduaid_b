<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AIChatMessage extends Model
{
    use HasFactory;

    protected $table = 'ai_chat_messages';

    protected $fillable = [
        'user_id',
        'lesson_id',
        'role',
        'message',
    ];

    /**
     * Get the user who sent/received this message.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the lesson context for this message (if any).
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class)->nullable();
    }

    /**
     * Check if this is a user message.
     */
    public function isUserMessage(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Check if this is an assistant message.
     */
    public function isAssistantMessage(): bool
    {
        return $this->role === 'assistant';
    }

    /**
     * Get conversation history for a user.
     */
    public static function getConversationHistory($userId, $limit = 50)
    {
        return self::where('user_id', $userId)
            ->latest()
            ->limit($limit)
            ->get()
            ->reverse();
    }
}
