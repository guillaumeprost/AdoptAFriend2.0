<?php
/**
 * Created by PhpStorm.
 * User: guillaumeprost
 * Date: 03/07/2016
 * Time: 11:29
 */

namespace App\Trait\Entity;

use Doctrine\ORM\Mapping as ORM;

trait ViewTrait
{
    /** @ORM\Column(type="integer") */
    private $views = 0;

    public function incrementViews()
    {
        $this->views++;
    }

    /**
     * @return mixed
     */
    public function getViews()
    {
        return $this->views;
    }
}
