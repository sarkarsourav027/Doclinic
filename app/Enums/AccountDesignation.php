<?php

namespace App\Enums;

enum AccountDesignation: string
{
    case ADMIN = 'Admin';
    case OFFICE_STAFF = 'Office Staff';
    case OFFICE_EXECUTIVE = 'Office Executive';
    case MANAGER = 'Manager';

    public static function getValues(): array
    {
        $types = [];
        foreach (self::cases() as $case) {
            $types[$case->value] = $case->value;
        }
        return $types;
    }
}

