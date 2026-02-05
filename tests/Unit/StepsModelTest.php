<?php

declare(strict_types=1);

use App\Models\Steps;

it('belongs to an idea', function () {
    $step = Steps::factory()->create();

    expect($step->Idea)->toBeInstanceOf(App\Models\Idea::class);
});
