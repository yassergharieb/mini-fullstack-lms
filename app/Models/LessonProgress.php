<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonProgress extends Model
{
    /** @use HasFactory<\Database\Factories\LessonProgressFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lesson_id',
        'started_at',
        'completed_at',
        'watch_seconds'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
