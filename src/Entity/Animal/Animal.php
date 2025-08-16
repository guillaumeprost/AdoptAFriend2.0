<?php

namespace App\Entity\Animal;

use App\Entity\AdoptionRequest\AdoptionRequest;
use App\Entity\Organisation;
use App\Entity\User;
use App\Entity\ValueObject\Address;
use App\Entity\ValueObject\GeoPoint;
use App\Repository\Animal\AnimalRepository;
use App\Traits\Entity as EntityTraits;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'species', type: 'string')]
#[ORM\DiscriminatorMap([
    Dog::DISCRIMINATOR => Dog::class,
    Cat::DISCRIMINATOR => Cat::class
])]
abstract class Animal
{
    const DISCRIMINATOR = 'animal';

    use EntityTraits\IdTrait;
    use EntityTraits\DescriptionTrait;
    use EntityTraits\StatusTrait;
    use EntityTraits\AffinitiesTrait;
    use TimestampableEntity;

    const STATUS_UP_FOR_ADOPTION = 'up for adoption';
    const STATUS_ADOPTED = 'adopted';
    const STATUS_DELETED = 'deleted';

    const DISCRIMINATORS = [
        'Chien' => Dog::DISCRIMINATOR,
        'Chat' => Cat::DISCRIMINATOR,
        'Animal' => Animal::DISCRIMINATOR
    ];

    public const DISCRIMINATOR_MAP = [
        Dog::DISCRIMINATOR => Dog::class,
        Cat::DISCRIMINATOR => Cat::class,
        Animal::DISCRIMINATOR => Animal::class,
    ];

    #[ORM\Column(nullable: false)]
    #[Assert\NotBlank(message: 'Veuillez ajouter un nom')]
    private string $name;

    #[ORM\Column(nullable: false)]
    #[Assert\NotBlank(message: 'Veuillez ajouter un sex')]
    private string $sex;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $birthDate;

    #[ORM\Column(nullable: true)]
    private ?array $images;

    #[ORM\Column(nullable: true)]
    private ?float $weight;

    #[ORM\Column(nullable: true)]
    private ?string $fur;

    #[ORM\Column(nullable: true)]
    private ?string $color;

    #[ORM\Column(nullable: true)]
    private ?bool $vaccination;

    #[ORM\Column(nullable: false)]
    private ?bool $sterilized;

    #[ORM\Column(nullable: false)]
    private ?bool $dewormed;

    #[ORM\Column(nullable: true)]
    private ?float $price;

    #[ORM\Embedded(class: Address::class, columnPrefix: 'address_')]
    private Address $address;

    #[ORM\Embedded(class: GeoPoint::class, columnPrefix: 'geo_')]
    private GeoPoint $location;

    #[ORM\Column(type:'string', nullable:true, columnDefinition:'GEOGRAPHY(POINT,4326)')]
    private ?string $geo = null;

    #[ORM\ManyToOne(targetEntity: Organisation::class, inversedBy: 'animals')]
    #[ORM\JoinColumn(name: 'organisation_id', referencedColumnName: 'id')]
    private ?Organisation $organisation = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'animals')]
    #[ORM\JoinColumn(name: 'manager_id', referencedColumnName: 'id')]
    private UserInterface $manager;

    #[ORM\OneToMany(mappedBy: 'animal', targetEntity: AdoptionRequest::class)]
    private Collection $adoptionRequests;

    public function __construct()
    {
        $this->adoptionRequests = new ArrayCollection();
        $this->address = new Address();
        $this->location = new GeoPoint();
    }

    abstract public function getType(): string;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Animal
    {
        $this->name = $name;
        return $this;
    }

    public function getSex(): string
    {
        return $this->sex;
    }

    public function setSex(string $sex): self
    {
        $this->sex = $sex;
        return $this;
    }

    public function getBirthDate(): \DateTime
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTime $birthDate): self
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function setImages(array $images): self
    {
        $this->images = $images;
        return $this;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): self
    {
        $this->weight = $weight;
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

    public function getFur(): string
    {
        return $this->fur;
    }

    public function setFur(string $fur): self
    {
        $this->fur = $fur;
        return $this;
    }

    public function isVaccination(): bool
    {
        return $this->vaccination;
    }

    public function setVaccination(bool $vaccination): self
    {
        $this->vaccination = $vaccination;
        return $this;
    }

    public function isSterilized(): bool
    {
        return $this->sterilized;
    }

    public function setSterilized(bool $sterilized): self
    {
        $this->sterilized = $sterilized;
        return $this;
    }

    public function isDewormed(): bool
    {
        return $this->dewormed;
    }

    public function setDewormed(bool $dewormed): self
    {
        $this->dewormed = $dewormed;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    public function getLocation(): GeoPoint
    {
        return $this->location;
    }

    public function setLocation(GeoPoint $location): void
    {
        $this->location = $location;
    }

    public function getGeo(): ?string
    {
        return $this->geo;
    }

    public function setGeo(?string $geo): void
    {
        $this->geo = $geo;
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

    public function getManager(): UserInterface
    {
        return $this->manager;
    }

    public function setManager(UserInterface $manager): self
    {
        $this->manager = $manager;
        return $this;
    }

    public function addAdoptionRequest(AdoptionRequest $adoptionRequest): self
    {
        $this->adoptionRequests->add($adoptionRequest);
        $adoptionRequest->setAnimal($this);
        return $this;
    }
}
