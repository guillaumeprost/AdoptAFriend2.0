<?php
/**
 * Created by PhpStorm.
 * User: guillaumeprost
 * Date: 06/05/2016
 * Time: 19:12
 */

namespace App\Traits\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AddressTrait
 * @package App\Traits\Entity
 */
trait AddressTrait
{
      /**
       * @var string
       * @ORM\Column(type="string", length=255, nullable=true)
       */
      private $address1;

      /**
       * @var string
       * @ORM\Column(type="string", length=255, nullable=true)
       */
      private $address2;

      /**
       * @var string
       * @ORM\Column(type="string", length=255, nullable=true)
       */
      private $postalCode;

      /**
       * @var string
       * @ORM\Column(type="string", length=255, nullable=true)
       */
      private $city;

      /**
       * @var string
       * @ORM\Column(type="string", length=255, nullable=true)
       */
      private $department;
      
      /**
       * @var string
       * @ORM\Column(type="string", length=255, nullable=true)
       */
      private $phone;

      /**
       * @return string
       */
      public function getAddress1()
      {
            return $this->address1;
      }

      /**
       * @param string $address1
       * @return $this
       */
      public function setAddress1($address1)
      {
            $this->address1 = $address1;
            return $this;
      }

      /**
       * @return string
       */
      public function getAddress2()
      {
            return $this->address2;
      }

      /**
       * @param string $address2
       * @return $this
       */
      public function setAddress2($address2)
      {
            $this->address2 = $address2;
            return $this;
      }

      /**
       * @return string
       */
      public function getPostalCode()
      {
            return $this->postalCode;
      }

      /**
       * @param string $postalCode
       * @return $this
       */
      public function setPostalCode($postalCode)
      {
            $this->postalCode = $postalCode;
            return $this;
      }

      /**
       * @return string
       */
      public function getCity()
      {
            return $this->city;
      }

      /**
       * @param string $city
       * @return $this
       */
      public function setCity($city)
      {
            $this->city = $city;
            return $this;
      }

      /**
       * @return string
       */
      public function getDepartment()
      {
            return $this->department;
      }

      /**
       * @param string $department
       * @return $this
       */
      public function setDepartment($department)
      {
            $this->department = $department;
            return $this;
      }

      /**
       * @return string
       */
      public function getPhone()
      {
            return $this->phone;
      }

      /**
       * @param string $phone
       * @return $this
       */
      public function setPhone($phone)
      {
            $this->phone = $phone;
            return $this;
      }
}
