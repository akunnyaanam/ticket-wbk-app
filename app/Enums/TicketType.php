<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum TicketType: string implements HasLabel, HasColor
{
    case REGULAR = 'regular';
    case PREMIUM = 'premium';

    public function getLabel(): string|Htmlable|null
    {
        return ucfirst($this->name);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::REGULAR => 'primary',
            self::PREMIUM => 'warning',
        };
    }
}
