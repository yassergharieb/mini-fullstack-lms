<?php

namespace App\Http\Controllers;

use App\Models\LessonProgress;
use App\Http\Requests\StoreLessonProgressRequest;
use App\Http\Requests\UpdateLessonProgressRequest;

class LessonProgressController extends Controller
{
    protected $progressService;

    public function __construct(\App\Services\ProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    public function updateProgress(UpdateLessonProgressRequest $request)
    {
        $lesson = \App\Models\Lesson::findOrFail($request->lesson_id);
        
        $progress = $this->progressService->updateProgress(
            auth()->user(),
            $lesson,
            $request->watch_seconds
        );

        return response()->json([
            'status' => 'success',
            'completed' => $progress->completed_at !== null,
            'progress' => $this->progressService->getCourseProgress(auth()->user(), $lesson->course)
        ]);
    }
}
