<?php

declare(strict_types=1);

namespace App;

enum Ideastatus: string
{
    case pending = 'pending';
    case Inprogress = 'inprogress';
    case completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::pending => 'pending' ,
            self::completed => 'completed',
            self::Inprogress => 'in progress',
        };
    }
}
