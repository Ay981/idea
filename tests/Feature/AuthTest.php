<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('registers a new user', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);

    $response->assertRedirect('/');

    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
    ]);
});

it('logs in an existing user', function () {
    $user = User::factory()->create([
        'password' => bcrypt('secret123'),
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'secret123',
    ]);

    $response->assertRedirect('/');
    $this->assertAuthenticatedAs($user);
});

it('logs out an authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = $this->post('/logout');

    $response->assertRedirect('/login');
    $this->assertGuest();
});
