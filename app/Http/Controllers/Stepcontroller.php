<?php

namespace App\Http\Controllers;
use App\Models\Steps;

use Illuminate\Http\Request;

class Stepcontroller extends Controller
{
    public function update(Steps $step)
    {
        $step->update([
            'completed' => ! $step->completed,
        ]);

        return back()->with('success','updated');




    }
    //
}
