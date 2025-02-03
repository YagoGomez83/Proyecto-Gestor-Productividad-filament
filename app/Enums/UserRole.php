<?php

namespace App\Enums;

enum UserRole: string
{
    case OPERATOR = 'operator';
    case SUPERVISOR = 'supervisor';
    case COORDINATOR = 'coordinator';

    public function label(): string
    {
        return match ($this) {
            self::OPERATOR => 'Operador',
            self::SUPERVISOR => 'Supervisor',
            self::COORDINATOR => 'Coordinador',
        };
    }
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
