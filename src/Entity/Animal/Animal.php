<?php

namespace App\Entity\Animal;

use App\Entity\Organisation;
use App\Repository\Animal\AnimalRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Traits\Entity as EntityTraits;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'species', type: 'string')]
#[ORM\DiscriminatorMap([Dog::DISCRIMINATOR => Dog::class])]
abstract class Animal
{
    use EntityTraits\IdTrait;
    use EntityTraits\DescriptionTrait;
    use EntityTraits\StatusTrait;
    use EntityTraits\AffinitiesTrait;
    use TimestampableEntity;

    const STATUS_UP_FOR_ADOPTION = 'up for adoption';
    const STATUS_ADOPTED = 'adopted';
    const STATUS_DELETED = 'deleted';

    const DISCRIMINATORS = [
        'Chien' => Dog::DISCRIMINATOR
    ];


    #[ORM\Column(nullable:false)]
    #[Assert\NotBlank(message:'Veuillez ajouter un nom')]
    private string $name;

    #[ORM\Column(nullable:false)]
    #[Assert\NotBlank(message:'Veuillez ajouter un sex')]
    private string $sex;

    #[ORM\Column(type: 'datetime', nullable:true)]
    private ?\DateTime $birthDate;

    #[ORM\Column(nullable:true)]
    private ?array $images;

    #[ORM\Column(nullable:true)]
    private ?float $weight;

    #[ORM\Column(nullable:true)]
    private ?string $fur;


    #[ORM\Column(nullable:true)]
    private ?string $color;

    #[ORM\Column(nullable:true)]
    private ?bool $vaccination;

    #[ORM\Column(nullable:false)]
    private ?bool $sterilized;

    #[ORM\Column(nullable:false)]
    private ?bool $dewormed;

    #[ORM\Column(nullable:true)]
    private ?float $price;

    #[ORM\ManyToOne(targetEntity: Organisation::class, inversedBy: 'animals')]
    #[ORM\JoinColumn(name: 'organisation_id', referencedColumnName: 'id')]
    private Organisation $organisation;

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
}
