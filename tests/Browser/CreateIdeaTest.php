<?php

declare(strict_types=1);

use App\Ideastatus;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;

uses(DatabaseMigrations::class);

it('creates a new idea', function () {
    $user = User::factory()->create();

    $this->browse(function (Browser $browser) use ($user) {
        $browser
            ->loginAs($user)
            ->visit('/ideas')
            ->click('@create-idea-button')
            ->waitForText('Create Idea')
            ->type('title', 'Some Example Title')
            ->click('@button-status-completed')
            ->type('text', 'An example description')
            ->click('@create-idea-submit')
            ->assertPathIs('/ideas')
            ->waitForText('u did it bro');
    });

    $this->assertDatabaseHas('ideas', [
        'user_id' => $user->id,
        'title' => 'Some Example Title',
        'text' => 'An example description',
        'status' => Ideastatus::completed->value,
    ]);
});
