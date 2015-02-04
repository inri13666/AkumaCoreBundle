<?php
/**
 * User  : Nikita.Makarov
 * Date  : 12/3/14
 * Time  : 7:55 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\CoreBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Filters extends \Twig_Extension implements ContainerAwareInterface
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('count', array($this, 'countFilter')),
            new \Twig_SimpleFilter('pre', array($this, 'preFilter'), array('is_safe' => array('html'))),
        );
    }

    public function preFilter($data)
    {
        return "<pre>" . print_r($data, true) . "</pre>";
    }

    public function countFilter($array)
    {
        return count($array);
    }

    public function getName()
    {
        return 'akuma_core.twig.filters';
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}