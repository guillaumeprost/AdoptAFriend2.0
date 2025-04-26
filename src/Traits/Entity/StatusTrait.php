<?php

namespace App\Traits\Entity;

use Doctrine\ORM\Mapping as ORM;

trait StatusTrait
{
    #[ORM\Column(nullable: false)]
    private string $status = 'active';

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }
}
