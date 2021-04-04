<?php

namespace App\Trait\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class IdTrait
 * @package App\Trait\Entity
 */
trait IdTrait
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue()
     */
    protected $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
