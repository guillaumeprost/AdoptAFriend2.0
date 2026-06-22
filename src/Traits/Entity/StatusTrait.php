<?php

namespace App\Traits\Entity;

use Doctrine\ORM\Mapping as ORM;

trait StatusTrait
{
    #[ORM\Column(nullable: false)]
    public private(set) string $status = 'active';

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }
}
