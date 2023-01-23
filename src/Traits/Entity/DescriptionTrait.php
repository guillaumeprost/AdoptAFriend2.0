<?php

namespace App\Traits\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait DescriptionTrait
{
    #[ORM\Column(type: 'text', nullable:true)]
    #[Assert\NotBlank(message: 'Veuillez ajouter une description')]
    private string $description;

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }
}
