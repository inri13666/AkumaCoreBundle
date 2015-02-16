<?php
/**
 * User  : Nikita.Makarov
 * Date  : 1/19/15
 * Time  : 8:59 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\CoreBundle\Doctrine\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait EntityModifiedTrait
 *
 * @package Misti\Bundle\CoreBundle\Traits
 *
 * @ORM\HasLifecycleCallbacks()
 */
trait EntityModifiedTrait
{
    /**
     * @var \DateTime
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    protected $updatedAt;

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $_
     *
     * @return $this
     */
    public function setCreatedAt(\DateTime $_)
    {
        $this->createdAt = $_;
        return $this;
    }


    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $_
     *
     * @return $this
     */
    public function setUpdatedAt(\DateTime $_)
    {
        $this->updatedAt = $_;
        return $this;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        if (is_null($this->getCreatedAt())) {
            $this->setCreatedAt(new \DateTime());
        }

    }
} 