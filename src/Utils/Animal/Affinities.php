<?php

namespace App\Utils\Animal;

class Affinities
{
    const TYPE_GOOD = 'good';
    const TYPE_BAD = 'bad';
    const TYPE_UNKNOWN = 'unknown';

    static $types = [
        self::TYPE_BAD => 'Mauvaise',
        self::TYPE_GOOD => 'Bonne',
        self::TYPE_UNKNOWN => 'Inconnue',
     ];
}