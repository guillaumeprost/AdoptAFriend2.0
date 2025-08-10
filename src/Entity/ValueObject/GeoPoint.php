<?php

namespace App\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final class GeoPoint
{
    #[ORM\Column(type:'float', nullable:true)]
    public ?float $lat = null;

    #[ORM\Column(type:'float', nullable:true)]
    public ?float $lng = null;
}