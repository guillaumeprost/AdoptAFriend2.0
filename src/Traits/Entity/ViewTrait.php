<?php

namespace App\Traits\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ViewTrait
{
    #[ORM\Column(type: 'integer')]
    private int $views = 0;

    public function incrementViews(): void
    {
        $this->views++;
    }

    public function getViews(): int
    {
        return $this->views;
    }
}
