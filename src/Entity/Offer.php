<?php
/**
 * Created by PhpStorm.
 * User: guillaumeprost
 * Date: 06/05/2016
 * Time: 18:33
 */

namespace AppBundle\Entity;

use AppBundle\Entity\Animal\Animal;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits as EntityTraits;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Offer
 * @package AppBundle\Entity
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\OfferRepository")
 */
class Offer
{
      use EntityTraits\IdTrait;
      use EntityTraits\DescriptionTrait;
      use EntityTraits\AddressTrait;
      use EntityTraits\StatusTrait;
      use EntityTraits\SlugTrait;
      use EntityTraits\TimestampableTrait;
      use EntityTraits\ViewTrait;

      const STATUS_DISABLED = 'disabled';
      const STATUS_ACTIVE   = 'active';
      const STATUS_DELETED  = 'deleted';
      const ANIMAL_TYPE_DOG     = 'Chien';


      /**
       * @var ArrayCollection
       * @ORM\OneToMany(targetEntity="AppBundle\Entity\Animal\Animal", mappedBy="offer", cascade={"persist"})
       */
      private $animals;

      /**
       * @var string
       * @Assert\NotNull()
       * @ORM\Column(type="string", nullable=false)
       */
      private $title;

      /**
       * @var string
       * @Assert\NotNull()
       * @ORM\Column(type="string", nullable=false)
       */
      private $animalType;

      public function __construct()
      {
            $this->animals = new ArrayCollection();
      }

      /**
       * @return ArrayCollection
       */
      public function getAnimals()
      {
            return $this->animals;
      }

      /**
       * @param ArrayCollection $animals
       * @return $this
       */
      public function setAnimals($animals)
      {
            $this->animals = $animals;
            return $this;
      }

      /**
       * @param Animal $animal
       * @return $this
       */
      public function addAnimal(Animal $animal)
      {
            if (! $this->animals->contains($animal)) {
                  $this->animals->add($animal);
                  $animal->setOffer($this);
            } elseif ($animal->getStatus() !== Animal::STATUS_ACTIVE) {
                  $animal->setStatus(Animal::STATUS_ACTIVE);
            }
            return $this;
      }

      /**
       * @param Animal $animal
       * @return $this
       */
      public function removeAnimal(Animal $animal)
      {
            if ($this->animals->contains($animal)) {
                  $animal->setStatus(Animal::STATUS_DELETED);
            }
            return $this;
      }

      /**
       * @return string
       */
      public function getTitle()
      {
            return $this->title;
      }

      /**
       * @param string $title
       * @return $this
       */
      public function setTitle($title)
      {
            $this->title = $title;
            return $this;
      }

      /**
       * @return string
       */
      public function getAnimalType()
      {
            return $this->animalType;
      }

      /**
       * @param string $animalType
       * @return $this
       */
      public function setAnimalType($animalType)
      {
            $this->animalType = $animalType;
            return $this;
      }
}
