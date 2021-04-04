<?php


namespace App\Utils\Animal\Dog;


class Size
{
    const TYPE_SMALL = 'small';
    const TYPE_MEDIUM = 'medium';
    const TYPE_BIG = 'big';
    const TYPE_VERY_BIG = 'very big';

    static $types = [
        self::TYPE_SMALL => 'Petit',
        self::TYPE_MEDIUM => 'Moyen',
        self::TYPE_BIG => 'Grand',
        self::TYPE_VERY_BIG => 'Très Grand',
    ];
}