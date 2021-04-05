<?php

namespace App\Utils\Animal;

/**
 * Class Sex
 * @package App\Utils\Animal
 */
class Sex
{
    const TYPE_MALE = 'male';
    const TYPE_FEMALE = 'female';
    const TYPE_UNKNOWN = 'unknown';

    static $types = [
        self::TYPE_MALE => 'Male',
        self::TYPE_FEMALE => 'Femelle',
        self::TYPE_UNKNOWN => 'Inconnue',
     ];
}