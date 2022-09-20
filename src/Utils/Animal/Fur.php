<?php

namespace App\Utils\Animal;

class Fur
{
    const TYPE_SHORT = 'short';
    const TYPE_HARD = 'hard';
    const TYPE_MEDIUM = 'medium';
    const TYPE_LONG = 'long';

    static array $types = [
        self::TYPE_SHORT => 'Courts',
        self::TYPE_HARD => 'Durs',
        self::TYPE_MEDIUM => 'Mi-longs',
        self::TYPE_LONG => 'Longs'
    ];
}
