<?php

declare(strict_types=1);

use App\Ideastatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates an idea for an authenticated user', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/ideas', [
        'title' => 'New idea',
        'text' => 'Some text',
        'status' => Ideastatus::pending->value,
    ]);

    $response->assertRedirect('/ideas');
    $response->assertSessionHasNoErrors();

    $this->assertDatabaseHas('ideas', [
        'user_id' => $user->id,
        'title' => 'New idea',
        'text' => 'Some text',
        'status' => Ideastatus::pending->value,
    ]);
});
