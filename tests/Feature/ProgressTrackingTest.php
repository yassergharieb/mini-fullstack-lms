<?php

use App\Events\CourseCompleted;
use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Level;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;

beforeEach(function () {
    $this->level = Level::factory()->create();
    $this->admin = User::factory()->create();
    $this->course = Course::factory()->published()->create([
        'level_id' => $this->level->id,
        'created_by' => $this->admin->id,
    ]);

    $this->lesson1 = Lesson::factory()->create([
        'course_id' => $this->course->id,
        'duration' => 100,
        'order' => 1,
    ]);

    $this->lesson2 = Lesson::factory()->create([
        'course_id' => $this->course->id,
        'duration' => 200,
        'order' => 2,
    ]);

    $this->user = User::factory()->create();
    $this->user->enrollments()->create(['course_id' => $this->course->id]);
});

test('recording lesson completion updates lesson_progress', function () {
    actingAs($this->user)
        ->postJson(route('lessons.progress.update'), [
            'lesson_id' => $this->lesson1->id,
            'watch_seconds' => 95, // 95% of 100
        ])
        ->assertStatus(200);

    $progress = LessonProgress::where('user_id', $this->user->id)
        ->where('lesson_id', $this->lesson1->id)
        ->first();

    expect($progress->completed_at)->not->toBeNull();
});

test('completing all lessons creates course_completions and sends email once', function () {
    \Illuminate\Support\Facades\Bus::fake();
    
    // Complete first lesson
    actingAs($this->user)
        ->postJson(route('lessons.progress.update'), [
            'lesson_id' => $this->lesson1->id,
            'watch_seconds' => 95,
        ]);

    expect(CourseCompletion::where('user_id', $this->user->id)->where('course_id', $this->course->id)->exists())->toBeFalse();
    \Illuminate\Support\Facades\Bus::assertNotDispatched(\App\Jobs\SendCourseCompletionEmailJob::class);

    // Complete second lesson
    actingAs($this->user)
        ->postJson(route('lessons.progress.update'), [
            'lesson_id' => $this->lesson2->id,
            'watch_seconds' => 190, // 95% of 200
        ]);

    expect(CourseCompletion::where('user_id', $this->user->id)->where('course_id', $this->course->id)->exists())->toBeTrue();
    \Illuminate\Support\Facades\Bus::assertDispatched(\App\Jobs\SendCourseCompletionEmailJob::class, 1);

    // Recording again should not send email again
    actingAs($this->user)
        ->postJson(route('lessons.progress.update'), [
            'lesson_id' => $this->lesson2->id,
            'watch_seconds' => 200,
        ]);

    \Illuminate\Support\Facades\Bus::assertDispatched(\App\Jobs\SendCourseCompletionEmailJob::class, 1);
});

test('unique slug constraint in database', function () {
    $course1 = Course::factory()->create(['slug' => 'unique-slug']);
    
    expect(fn () => Course::factory()->create(['slug' => 'unique-slug']))
        ->toThrow(\Illuminate\Database\QueryException::class);
});
