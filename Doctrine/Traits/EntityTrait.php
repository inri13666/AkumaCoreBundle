<?php
/**
 * User  : Nikita.Makarov
 * Date  : 1/19/15
 * Time  : 8:59 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\CoreBundle\Doctrine\Traits;

use Doctrine\ORM\Mapping as ORM;

trait EntityTrait
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id",type="bigint",options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
} 