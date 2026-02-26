<?php

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Level;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function () {
    $this->level = Level::factory()->create();
    $this->admin = User::factory()->create();
    $this->course = Course::factory()->create([
        'level_id' => $this->level->id,
        'created_by' => $this->admin->id,
        'is_published' => true,
    ]);

    $this->freeLesson = Lesson::factory()->create([
        'course_id' => $this->course->id,
        'is_free_preview' => true,
        'published' => true,
    ]);

    $this->paidLesson = Lesson::factory()->create([
        'course_id' => $this->course->id,
        'is_free_preview' => false,
        'published' => true,
    ]);
});

test('guests can access free preview lessons', function () {
    get(route('courses.show', $this->course))
        ->assertStatus(200)
        ->assertSee($this->freeLesson->title);
});

test('guests cannot access non-preview lessons', function () {
    // This assumes the view logic only shows free lessons to guests
    get(route('courses.show', $this->course))
        ->assertStatus(200)
        ->assertSee($this->freeLesson->title)
        ->assertDontSee($this->paidLesson->title);
});

test('enrolled users can access all lessons', function () {
    $user = User::factory()->create();
    $user->enrollments()->create(['course_id' => $this->course->id]);

    actingAs($user)
        ->get(route('courses.show', $this->course))
        ->assertStatus(200)
        ->assertSee($this->freeLesson->title)
        ->assertSee($this->paidLesson->title);
});
