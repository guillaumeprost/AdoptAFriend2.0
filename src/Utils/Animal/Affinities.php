<?php

namespace App\Utils\Animal;

use Symfony\Contracts\Translation\TranslatorInterface;

enum Affinities: string
{
    case Good = 'Bonne';
    case Bad = 'Mauvaise';
    case Unknown = 'Inconnue';


    public function trans(TranslatorInterface $translator, ?string $locale = null): string
    {

        // Translate enum using custom labels
        return match ($this) {
            self::Good  => 'Bonne',
            self::Bad => 'Mauvaise',
            self::Unknown  => 'Inconnue',
        };
    }
}