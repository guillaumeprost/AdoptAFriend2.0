<?php

namespace App\Entity;


use App\Entity\Animal\Animal;
use App\Repository\AdoptionRequestRepository;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Traits\Entity as EntityTraits;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdoptionRequestRepository::class)]
class AdoptionRequest
{
    const STATUS_NEW = 'new';

    use EntityTraits\IdTrait;
    use EntityTraits\DescriptionTrait;
    use TimestampableEntity;

    #[ORM\Column(nullable: false)]
    private string $status = self::STATUS_NEW;

    #[ORM\Column(nullable: false)]
    private string $name;

    #[ORM\Column(length: 180, nullable: false)]
    private string $email;

    #[ORM\Column()]
    private int $phone;

    #[ORM\ManyToOne(targetEntity: Animal::class, inversedBy: 'adoptionRequests')]
    #[ORM\JoinColumn(name: 'animal_id', referencedColumnName: 'id')]
    private Animal $animal;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPhone(): int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    public function getAnimal(): Animal
    {
        return $this->animal;
    }

    public function setAnimal(Animal $animal): self
    {
        $this->animal = $animal;
        return $this;
    }
}