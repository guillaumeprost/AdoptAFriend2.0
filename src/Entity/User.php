<?php

namespace App\Entity;

use App\Entity\AdoptionRequest\AdoptionRequest;
use App\Entity\Animal\Animal;
use App\Repository\UserRepository;
use App\Traits\Entity\IdTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: "There is already an account with this email")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use IdTrait;
    use TimestampableEntity;

    #[ORM\Column(length: 180, unique: true)]
    public private(set) string $email;

    #[ORM\Column(nullable: false)]
    public private(set) string $name;

    #[ORM\Column(nullable: false)]
    public private(set) string $firstName;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column]
    private string $password;

    #[ORM\Column]
    public private(set) bool $isVerified = false;

    #[ORM\ManyToOne(targetEntity: Organisation::class, inversedBy: 'users')]
    #[ORM\JoinColumn(name: 'organisation_id', referencedColumnName: 'id', nullable: true)]
    private ?Organisation $organisation = null;

    #[ORM\OneToMany(mappedBy: 'manager', targetEntity: Animal::class)]
    private Collection $animals;

    #[ORM\OneToMany(mappedBy: 'adopter', targetEntity: AdoptionRequest::class)]
    private Collection $adoptionRequests;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
        $this->adoptionRequests = new ArrayCollection();
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getUsername(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;
        return $this;
    }

    public function eraseCredentials(): void {}

    public function getOrganisation(): ?Organisation
    {
        return $this->organisation;
    }

    public function setOrganisation(?Organisation $organisation): static
    {
        $this->organisation = $organisation;
        return $this;
    }

    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function getAdoptionRequests(): Collection
    {
        return $this->adoptionRequests;
    }
}
