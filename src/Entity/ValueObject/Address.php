<?php

namespace App\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
final class Address
{
    #[ORM\Column(length:255, nullable:true)]
    #[Assert\Length(max:255)]
    public ?string $line1 = null;

    #[ORM\Column(length:255, nullable:true)]
    public ?string $line2 = null;

    #[ORM\Column(length:32, nullable:true)]
    public ?string $postalCode = null;

    #[ORM\Column(length:150, nullable:true)]
    public ?string $city = null;

    #[ORM\Column(length:2, nullable:true, options: ['default'=>'FR'])]
    public ?string $country = 'FR';
}