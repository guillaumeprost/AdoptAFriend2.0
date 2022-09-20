<?php

namespace App\Utils\Animal;

/**
 *  POC
 */
class Color
{
    static array $types = [
        "Abricot" => "Abricot",
        "Albinos" => "Albinos",
        "Alezan" => "Alezan",
        "Arlequin" => "Arlequin",
        "Bai" => "Bai",
        "Beige" => "Beige",
        "Blanc" => "Blanc",
        "Blanc avec marque noire" => "Blanc avec marque noire",
        "Bleu et blanc" => "Bleu et blanc",
        "Bleu merle" => "Bleu merle",
        "Bringé" => "Bringé",
        "Caramel" => "Caramel",
        "Champagne" => "Champagne",
        "Chocolat" => "Chocolat",
        "Chocolat et blanc" => "Chocolat et blanc",
        "Couleur indéfinie" => "Couleur indéfinie",
        "Crème" => "Crème",
        "Ecaille de tortue" => "Ecaille de tortue",
        "Fauve" => "Fauve",
        "Fauve charbonné" => "Fauve charbonné",
        "Gris" => "Gris",
        "Gris et blanc" => "Gris et blanc",
        "Isabelle" => "Isabelle",
        "Marron" => "Marron",
        "Marron et blanc" => "Marron et blanc",
        "Merle" => "Merle",
        "Noir" => "Noir",
        "Noir avec marque blanche" => "Noir avec marque blanche",
        "Noir et Feu" => "Noir et Feu",
        "Noir et beige" => "Noir et beige",
        "Noir et blanc" => "Noir et blanc",
        "Noir et gris" => "Noir et gris",
        "Noir tri" => "Noir tri",
        "Pluricoloré" => "Pluricoloré",
        "Putoisé" => "Putoisé",
        "Rouge merle" => "Rouge merle",
        "Rouge tri" => "Rouge tri",
        "Roux" => "Roux",
        "Roux et blanc" => "Roux et blanc",
        "Sable" => "Sable",
        "Sanglier" => "Sanglier",
        "Seal point" => "Seal point",
        "Tacheté" => "Tacheté",
        "Tigré" => "Tigré",
        "Tigré blanc" => "Tigré blanc",
        "Tigré gris" => "Tigré gris",
        "Tigré roux" => "Tigré roux",
        "Tricolore" => "Tricolore",
    ];

    static function convert(): array
    {
        $data = file_get_contents('data_color.html', true);
        $result = [];
        $list = explode('</option>', $data);
        foreach ($list as $color) {
            $result[trim(strip_tags($color))] = trim(strip_tags($color));
        }

        return $result;
    }
}