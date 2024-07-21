<?php

namespace App\Enums;

enum DaysOfWeek: string
{
    case SUNDAY = 'SUNDAY';
    case MONDAY = 'MONDAY';
    case TUESDAY = 'TUESDAY';
    case WEDNESDAY = 'WEDNESDAY';
    case THURSDAY = 'THURSDAY';
    case FRIDAY = 'FRIDAY';
    case SATURDAY = 'SATURDAY';

    public static function getValues(): array
    {
        $types = [];
        foreach (self::cases() as $case) {
            $types[$case->value] = $case->value;
        }
        return $types;
    }
}

