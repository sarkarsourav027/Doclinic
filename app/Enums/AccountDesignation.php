<?php

namespace App\Enums;

enum AccountDesignation: string
{
    case SUPER_ADMIN = 'SUPER_ADMIN';
    case ADMIN = 'ADMIN';
    case OFFICE_STAFF = 'OFFICE_STAFF';
    case OFFICE_EXECUTIVE = 'OFFICE_EXECUTIVE';
    case MANAGER = 'MANAGER';

    public static function getValues(): array
    {
        $types = [];
        foreach (self::cases() as $case) {
            $types[$case->value] = $case->value;
        }
        return $types;
    }
}
