<?php

declare(strict_types=1);

namespace App\Models;

use App\Ideastatus;
use Database\Factories\IdeaFactory;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model\Steps;
use Illuminate\Database\Eloquent\Model\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Idea extends Model
{
    /** @use HasFactory<IdeaFactory> */
    use HasFactory;

    protected $casts = [
        'links' => AsArrayObject::class,
        'status' => Ideastatus::class,
    ];

    protected $attributes = [
        'status' => Ideastatus::pending,

    ];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);

    }

    public function Steps(): HasMany
    {
        return $this->hasMany(Steps::class);
    }
}
