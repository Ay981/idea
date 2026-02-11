<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Steps;

class Stepcontroller extends Controller
{
    public function update(Steps $step)
    {
        $step->update([
            'completed' => ! $step->completed,
        ]);

        return back()->with('success', 'updated');

    }
    //
}
