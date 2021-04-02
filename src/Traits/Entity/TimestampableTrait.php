<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * ThisTrait adds Timestampable fields to entity.
 */
trait TimestampableTrait
{
    /**
     * @var \Datetime $created
     *
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \Datetime $updated
     *
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @return \Datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \Datetime $created
     * @return self
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * @return \Datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \Datetime $updated
     * @return self
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }
}
