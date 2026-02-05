<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\StepsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Steps extends Model
{
    /** @use HasFactory<StepsFactory> */
    use HasFactory;

    public function Idea()
    {
        return $this->belongsTo(Idea::class);
    }
}
