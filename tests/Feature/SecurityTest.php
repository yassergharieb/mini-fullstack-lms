<?php

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\Level;
use App\Models\User;
use function Pest\Laravel\actingAs;

beforeEach(function () {
    $this->level = Level::factory()->create();
    $this->course = Course::factory()->published()->create(['level_id' => $this->level->id]);
    $this->lesson = Lesson::factory()->create(['course_id' => $this->course->id]);
    
    $this->user1 = User::factory()->create();
    $this->user2 = User::factory()->create();
});

test('users cannot modify others enrollments', function () {
    $enrollment2 = Enrollment::create([
        'user_id' => $this->user2->id,
        'course_id' => $this->course->id,
    ]);

    actingAs($this->user1);
    
    // Check view policy
    expect($this->user1->can('view', $enrollment2))->toBeFalse();
    
    // Check update policy
    expect($this->user1->can('update', $enrollment2))->toBeFalse();
    
    // Check delete policy
    expect($this->user1->can('delete', $enrollment2))->toBeFalse();
});

test('users cannot modify others progress', function () {
    $progress2 = LessonProgress::create([
        'user_id' => $this->user2->id,
        'lesson_id' => $this->lesson->id,
        'watch_seconds' => 10,
        'started_at' => now(),
    ]);

    actingAs($this->user1);

    // Check update policy
    expect($this->user1->can('update', $progress2))->toBeFalse();
    
    // Check delete policy
    expect($this->user1->can('delete', $progress2))->toBeFalse();
});
