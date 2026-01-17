<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum UserRole: string implements HasColor, HasLabel
{
    case ADMIN = 'admin';
    case USER = 'user';

    public function getLabel(): string|Htmlable|null
    {
        return ucfirst($this->name);
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::ADMIN => 'red',
            self::USER => 'blue',
        };
    }
}
