<?php
/**
 * Created by PhpStorm.
 * User: guillaumeprost
 * Date: 06/05/2016
 * Time: 11:06
 */

namespace App\Entity\Animal;

use AppBundle\Entity\Offer;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits as EntityTraits;

/**
 * Class Animal
 * @package AppBundle\Entity\Animal
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

    const STATUS_DISABLED = 'disabled';
    const STATUS_ACTIVE = 'active';
    const STATUS_DELETED = 'deleted';

    const DISCRIMINATORS = [
        'Chien' => 'dog'
    ];

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthDate;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $weight;

    /**
     * @var Offer
     * @ORM\ManyToOne(targetEntity="App\Entity\Offer", inversedBy="animals", cascade={"persist"})
     */
    private $offer;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $vaccination;

    /**
     * @return string
     */
    public function getBreed1()
    {
        return $this->breed1;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getVaccination()
    {
        return $this->vaccination;
    }

    /**
     * @param string $vaccination
     * @return $this
     */
    public function setVaccination($vaccination)
    {
        $this->vaccination = $vaccination;
        return $this;
    }

    /**
     * @return Offer
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * @param Offer $offer
     * @return $this
     */
    public function setOffer($offer)
    {
        $this->offer = $offer;
        return $this;
    }
}
