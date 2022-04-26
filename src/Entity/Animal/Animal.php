<?php

namespace App\Entity\Animal;

use Doctrine\ORM\Mapping as ORM;
use App\Traits\Entity as EntityTraits;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnimalRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="species", type="string")
 * @ORM\DiscriminatorMap({Dog::DISCRIMINATOR = "Dog"})
 */
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

    /**
     * @Assert\NotBlank(message="Veuillez ajouter un nom")
     * @ORM\Column(type="string", nullable=false)
     */
    private string $name;

    /**
     * @Assert\NotBlank(message="Veuillez ajouter un sex")
     * @ORM\Column(type="string", nullable=false)
     */
    private string $sex;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTime $birthDate;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private ?array $images;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     */
    private ?float $weight;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $fur;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private ?String $color;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $vaccination;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private ?bool $sterilized;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private ?bool $dewormed;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     */
    private ?float $price;

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
