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
#[ORM\Table(name:'`user`')]
#[UniqueEntity(fields: ['email'], message: "There is already an account with this email")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use IdTrait;
    use TimestampableEntity;

    #[ORM\Column(length: 180, unique: true)]
    private string $email;

    #[ORM\Column(nullable: false)]
    private string $name;

    #[ORM\Column(nullable: false)]
    private string $firstName;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column]
    private string $password;

    #[ORM\Column]
    private bool $isVerified = false;

    #[ORM\ManyToOne(targetEntity: Organisation::class, inversedBy: 'users')]
    #[ORM\JoinColumn(name: 'organisation_id', referencedColumnName: 'id', nullable: true)]
    private ?Organisation $organisation;

    #[ORM\OneToMany(mappedBy: 'manager', targetEntity: Animal::class)]
    private Collection $animals;

    #[ORM\OneToMany(mappedBy: 'adopter', targetEntity: AdoptionRequest::class)]
    private Collection $adoptionRequests;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): string
    {
        return (string)$this->email;
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

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
//        $this->password = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getOrganisation(): ?Organisation
    {
        return $this->organisation;
    }

    public function setOrganisation(?Organisation $organisation): self
    {
        $this->organisation = $organisation;
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

    public function getAdoptionRequests(): Collection
    {
        return $this->adoptionRequests;
    }
}
