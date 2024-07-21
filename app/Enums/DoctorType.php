<?php

namespace App\Enums;

enum DoctorType: string
{
    case CARDIOLOGIST = 'CARDIOLOGIST';
    case ORTHOPEDIC = 'ORTHOPEDIC';
    case ONCOLOGIST = 'ONCOLOGIST';
    case RADIOLOGIST = 'RADIOLOGIST';
    case NEPHROLOGY = 'NEPHROLOGY';

    public static function getValues(): array
    {
        $types = [];
        foreach (self::cases() as $case) {
            $types[$case->value] = $case->value;
        }
        return $types;
    }
}

