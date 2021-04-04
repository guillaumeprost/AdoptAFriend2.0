<?php
/**
 * Created by PhpStorm.
 * User: guillaumeprost
 * Date: 06/05/2016
 * Time: 11:24
 */

namespace App\Entity\Animal;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Dog
 * @package App\Entity\Animal
 *
 * @ORM\Entity(repositoryClass="App\Entity\Repository\Animal\DogRepository")
 */
class Dog extends Animal
{
    const DISCIMINATOR = 'dog';

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $size;

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     * @return Dog
     */
    public function setSize(string $size): self
    {
        $this->size = $size;
        return $this;
    }
}