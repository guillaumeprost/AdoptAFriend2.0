<?php
/**
 * Created by PhpStorm.
 * User: guillaumeprost
 * Date: 06/05/2016
 * Time: 11:06
 */

namespace AppBundle\Entity\Animal;

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
      const STATUS_ACTIVE   = 'active';
      const STATUS_DELETED  = 'deleted';

    const DISCRIMINATORS = [
        'Chien' => 'dog'
    ];

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $breed1;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $breed2;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $vaccination;

    /**
     * @var Offer
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Offer", inversedBy="animals", cascade={"persist"})
     */
    private $offer;

    /**
     * @return string
     */
    public function getBreed1()
    {
        return $this->breed1;
    }

    /**
     * @param string $breed1
     * @return $this
     */
    public function setBreed1($breed1)
    {
        $this->breed1 = $breed1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBreed2()
    {
        return $this->breed2;
    }

    /**
     * @param mixed $breed2
     * @return $this
     */
    public function setBreed2($breed2)
    {
        $this->breed2 = $breed2;
        return $this;
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
