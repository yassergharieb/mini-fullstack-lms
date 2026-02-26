<?php

use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('regular users cannot access filament admin', function () {
    $user = User::factory()->create();

    actingAs($user)->get('/admin')->assertForbidden();
});

test('admins can access filament admin', function () {
    $admin = User::factory()->create();
    \Spatie\Permission\Models\Role::create(['name' => 'super_admin']);
    $admin->assignRole('super_admin'); // Assuming shield uses this role

    actingAs($admin)->get('/admin')->assertStatus(200);
});
