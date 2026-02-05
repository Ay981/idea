<?php

declare(strict_types=1);

use App\Models\Idea;

it('has a user relation and steps relation', function () {
    $idea = Idea::factory()->create();

    expect($idea->user)->toBeInstanceOf(App\Models\User::class);
    expect($idea->steps)->toBeInstanceOf(Illuminate\Database\Eloquent\Collection::class);
});
