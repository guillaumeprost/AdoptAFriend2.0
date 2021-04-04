<?php
/**
 * Created by PhpStorm.
 * User: guillaumeprost
 * Date: 06/05/2016
 * Time: 19:22
 */

namespace App\Trait\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class EmailTrait
 * @package App\Trait\Entity
 */
trait EmailTrait
{
      /**
       * @var string
       * @Assert\Email
       * @ORM\Column(type="string", length=255, nullable=true)
       */
      private $email;

      /**
       * @return string
       */
      public function getEmail()
      {
            return $this->email;
      }

      /**
       * @param string $email
       * @return $this
       */
      public function setEmail($email)
      {
            $this->email = $email;
            return $this;
      }
}
