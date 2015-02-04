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

class Functions extends \Twig_Extension implements ContainerAwareInterface
{
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(//'???' => new \Twig_Function_Method($this, '???'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'akuma.core.twig.functions';
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