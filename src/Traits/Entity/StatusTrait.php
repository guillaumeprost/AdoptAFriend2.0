<?php
/**
 * Created by PhpStorm.
 * User: guillaumeprost
 * Date: 06/05/2016
 * Time: 19:34
 */

namespace App\Traits\Entity;

use Doctrine\ORM\Mapping as ORM;

trait StatusTrait
{
      /**
       * @var string
       * @ORM\Column(type="string", nullable=false)
       */
      private $status = 'active';

      /**
       * @return string
       */
      public function getStatus()
      {
            return $this->status;
      }

      /**
       * @param string $status
       * @return $this
       */
      public function setStatus($status)
      {
            $this->status = $status;
            return $this;
      }
}