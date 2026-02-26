<?php

use App\Jobs\SendWelcomeEmailJob;
use Illuminate\Support\Facades\Bus;
use function Pest\Laravel\post;

test('registration sends welcome email', function () {
    Bus::fake();

    $response = post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect(route('home'));

    Bus::assertDispatched(SendWelcomeEmailJob::class);
});
