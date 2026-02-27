<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;

class LessonController extends Controller
{
    protected $progressService;

    public function __construct(\App\Services\ProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    public function play(\App\Models\Course $course, Lesson $lesson = null)
    {
        $course->load(['lessons' => function($query) {
            $query->orderBy('order');
        }]);

        if (!$lesson || $lesson->course_id !== $course->id) {
            $lesson = $course->lessons->first();
        }

        if (!$lesson) {
            return redirect()->route('courses.show', $course->slug)->with('error', 'No lessons available.');
        }

        $nextLesson = $course->lessons->where('order', '>', $lesson->order)->sortBy('order')->first();
        $previousLesson = $course->lessons->where('order', '<', $lesson->order)->sortByDesc('order')->first();

        $completedLessonsCount = \App\Models\LessonProgress::where('user_id', auth()->id())
            ->whereIn('lesson_id', $course->lessons->pluck('id'))
            ->whereNotNull('completed_at')
            ->count();
        
        $percentage = $this->progressService->getCourseProgress(auth()->user(), $course);

        return view('course', [
            'course' => $course,
            'currentLesson' => $lesson,
            'nextLesson' => $nextLesson,
            'previousLesson' => $previousLesson,
            'completedCount' => $completedLessonsCount,
            'percentage' => $percentage,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        //
    }
}
