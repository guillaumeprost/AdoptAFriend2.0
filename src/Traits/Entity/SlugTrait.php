<?php
/**
 * Created by PhpStorm.
 * User: guillaumeprost
 * Date: 07/05/2016
 * Time: 10:26
 */

namespace AppBundle\Entity\Traits;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class SlugTrait
 * @package AppBundle\Entity\Traits
 */
trait SlugTrait
{
      /**
       * @var string
       * @ORM\Column(type="string", length=255, nullable=true)
       */
      private $slug;

      /**
       * @return string
       */
      public function getSlug()
      {
            return $this->slug;
      }

      /**
       * @param string $slug
       * @return $this
       */
      public function setSlug($slug)
      {
            $this->slug = (new Slugify())->slugify($slug);
            return $this;
      }
}
