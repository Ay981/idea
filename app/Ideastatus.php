<?php

declare(strict_types=1);

namespace App;

enum Ideastatus: string
{
    case pending = 'pending';
    case Inprogress = 'inprogress';
    case completed = 'completed';

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_map(
            static fn (self $case): string => $case->value,
            self::cases(),
        );
    }

    public function label(): string
    {
        return match ($this) {
            self::pending => 'pending' ,
            self::completed => 'completed',
            self::Inprogress => 'in progress',
        };
    }
}
