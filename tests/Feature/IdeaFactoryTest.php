<?php

declare(strict_types=1);

use App\Models\Idea;
use App\Models\Steps;

it('creates idea and step records via factories', function () {
    $idea = Idea::factory()->create();
    $step = Steps::factory()->create(['idea_id' => $idea->id]);

    $this->assertDatabaseHas('ideas', ['id' => $idea->id]);
    $this->assertDatabaseHas('steps', ['id' => $step->id, 'idea_id' => $idea->id]);
});
