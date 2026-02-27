<?php

use App\Models\User;
use App\Jobs\SendWelcomeEmailJob;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\RateLimiter;
use function Pest\Laravel\post;
use function Pest\Laravel\postJson;

test('registration requires a name', function () {
    post('/register', [
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('name');
});

test('registration requires a unique email', function () {
    User::factory()->create(['email' => 'duplicate@example.com']);

    post('/register', [
        'name' => 'Test User',
        'email' => 'duplicate@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertSessionHasErrors('email');
});

test('registration requires password confirmation', function () {
    post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'wrong-password',
    ])->assertSessionHasErrors('password');
});

test('registration dispatches welcome email job', function () {
    Bus::fake();

    post('/register', [
        'name' => 'Test User',
        'email' => 'newuser@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    Bus::assertDispatched(SendWelcomeEmailJob::class, function ($job) {
        return $job->user->email === 'newuser@example.com';
    });
});

test('login is rate limited after too many attempts', function () {
    $user = User::factory()->create();

    for ($i = 0; $i < 5; $i++) {
        post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
    }

    // 6th attempt should be throttled
    $response = post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors('email');
    $error = session('errors')->get('email')[0];
    expect($error)->toMatch('/seconds|minutes/');
});

test('login regenerates session ID', function () {
    $user = User::factory()->create();
    $oldSessionId = session()->getId();

    post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    expect(session()->getId())->not->toBe($oldSessionId);
});
