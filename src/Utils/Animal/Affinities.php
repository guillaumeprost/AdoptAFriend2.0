<?php

namespace App\Utils\Animal;

enum Affinities: string
{
    case TYPE_GOOD = 'good';
    case TYPE_BAD = 'bad';
    case TYPE_UNKNOWN = 'unknown';
}