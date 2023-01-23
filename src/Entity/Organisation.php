<?php

namespace App\Entity;
use App\Entity\Animal\Animal;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity()]
class Organisation
{
    #[Id]
    #[GeneratedValue]
    #[Column]
    private int $id;

    #[Column(nullable:false)]
    private string $name;

    #[Column]
    private string $logo;

    #[Column]
    private string $color;

    #[Column]
    private ?array $images;

    #[Column]
    private string $address;

    #[Column(type:'text')]
    private string $description;

    #[Column(type:'text')]
    private string $signature;

    #[OneToMany(mappedBy: 'organisation', targetEntity: Animal::class)]
    private Collection $animals;

    #[OneToMany(mappedBy: 'organisation', targetEntity: User::class)]
    private Collection $users;

    public function __construct() {
        $this->animals = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;
        return $this;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;
        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(?array $images): self
    {
        $this->images = $images;
        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }

    public function setSignature(string $signature): self
    {
        $this->signature = $signature;
        return $this;
    }

    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function setAnimals(Collection $animals): self
    {
        $this->animals = $animals;
        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function setUsers(Collection $users): self
    {
        $this->users = $users;
        return $this;
    }
}