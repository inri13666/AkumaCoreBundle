<?php
/**
 * User  : Nikita.Makarov
 * Date  : 5/29/15
 * Time  : 6:27 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\CoreBundle\Controller;


use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class AbstractController extends Controller
{
    /**
     * @param null $name
     *
     * @return EntityManager
     */
    public function getManager($name = null)
    {
        return $this->getDoctrine()->getManager($name);
    }

    public function getParameter($name)
    {
        return $this->container->getParameter($name);
    }
} 