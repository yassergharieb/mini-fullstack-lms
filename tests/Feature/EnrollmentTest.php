<?php

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Level;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\post;

beforeEach(function () {
    $this->level = Level::factory()->create();
    $this->admin = User::factory()->create();
    $this->course = Course::factory()->create([
        'level_id' => $this->level->id,
        'created_by' => $this->admin->id,
        'is_published' => true,
        'price' => 10,
    ]);
});

test('enrollment requires login', function () {
    post(route('courses.enroll', $this->course))->assertRedirect('/login');
});

test('enrollment restricted on draft courses', function () {
    $user = User::factory()->create();
    $draftCourse = Course::factory()->create([
        'level_id' => $this->level->id,
        'created_by' => $this->admin->id,
        'is_published' => false,
        'price' => 10,
    ]);

    actingAs($user)
        ->post(route('courses.enroll', $draftCourse))
        ->assertRedirect()
        ->assertSessionHas('error', 'This course is currently a draft and not open for enrollment.');
});

test('enrollment is idempotent', function () {
    $user = User::factory()->create();

    actingAs($user)->post(route('courses.enroll', $this->course))->assertRedirect();
    actingAs($user)->post(route('courses.enroll', $this->course))->assertRedirect();

    expect(Enrollment::where('user_id', $user->id)->where('course_id', $this->course->id)->count())->toBe(1);
});
