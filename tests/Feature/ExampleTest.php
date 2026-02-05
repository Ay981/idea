<?php

test('the application returns a successful response', function () {
    // Follow redirects (e.g., to login) and assert final response is successful
        $response = $this->get('/');

        // Allow either a direct 200 response or a 302 redirect (e.g. to login)
        // This test will be split into two separate cases
});

use App\Models\User;

test('guest is redirected to login', function () {
    $response = $this->get('/');

    $response->assertRedirect('/login');
});

test('authenticated user can view the homepage', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/');

    $response->assertOk();
});
});
