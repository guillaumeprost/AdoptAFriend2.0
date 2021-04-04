<?php
/**
 * Created by PhpStorm.
 * User: guillaumeprost
 * Date: 06/05/2016
 * Time: 11:06
 */

namespace App\Entity\Animal;

use App\Entity\Offer;
use Doctrine\ORM\Mapping as ORM;
use App\Trait\Entity as EntityTraits;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Animal
 * @package App\Entity\Animal
 *
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 * @ORM\DiscriminatorMap({"dog" = "Dog"})
 */
abstract class Animal
{
    use EntityTraits\IdTrait;
    use EntityTraits\DescriptionTrait;
    use EntityTraits\StatusTrait;
    use EntityTraits\AffinitiesTrait;

    const STATUS_UP_FOR_ADOPTION = 'up for adoption';
    const STATUS_ADOPTED = 'adopted';
    const STATUS_DELETED = 'deleted';

    const DISCRIMINATORS = [
        'Chien' => Dog::DISCIMINATOR
    ];

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez ajouter un nom")
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthDate;

    /**
     * @var float
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $weight;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $fur;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $color;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $vaccination;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $sterilized;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $dewormed;

    /**
     * @var float
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $price;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Animal
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate(): \DateTime
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     * @return Animal
     */
    public function setBirthDate(\DateTime $birthDate): Animal
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     * @return Animal
     */
    public function setWeight(float $weight): Animal
    {
        $this->weight = $weight;
        return $this;
    }
    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return Animal
     */
    public function setColor(string $color): self
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return string
     */
    public function getFur(): string
    {
        return $this->fur;
    }

    /**
     * @param string $fur
     * @return Animal
     */
    public function setFur(string $fur): Animal
    {
        $this->fur = $fur;
        return $this;
    }

    /**
     * @return bool
     */
    public function isVaccination(): bool
    {
        return $this->vaccination;
    }

    /**
     * @param bool $vaccination
     */
    public function setVaccination(bool $vaccination): self
    {
        $this->vaccination = $vaccination;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSterilized(): bool
    {
        return $this->sterilized;
    }

    /**
     * @param bool $sterilized
     * @return Animal
     */
    public function setSterilized(bool $sterilized): Animal
    {
        $this->sterilized = $sterilized;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDewormed(): bool
    {
        return $this->dewormed;
    }

    /**
     * @param bool $dewormed
     * @return Animal
     */
    public function setDewormed(bool $dewormed): Animal
    {
        $this->dewormed = $dewormed;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Animal
     */
    public function setPrice(float $price): Animal
    {
        $this->price = $price;
        return $this;
    }
}
