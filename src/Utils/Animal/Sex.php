<?php

namespace App\Utils\Animal;

class Sex
{
    const TYPE_MALE = 'male';
    const TYPE_FEMALE = 'female';
    const TYPE_UNKNOWN = 'unknown';

    static array $choices = [
        self::TYPE_MALE => 'Male',
        self::TYPE_FEMALE => 'Femelle',
        self::TYPE_UNKNOWN => 'Inconnue',
    ];
}