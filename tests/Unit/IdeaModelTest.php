<?php

declare(strict_types=1);

use App\Models\Idea;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

it('has a user relation and steps relation', function () {
    $idea = Idea::factory()->create();

    expect($idea->user)->toBeInstanceOf(User::class);
    expect($idea->steps)->toBeInstanceOf(Collection::class);
});
