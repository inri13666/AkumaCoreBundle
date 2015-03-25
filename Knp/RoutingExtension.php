<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/24/15
 * Time  : 8:20 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\CoreBundle\Knp;


use Knp\Menu\Factory\ExtensionInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Factory able to use the Symfony2 Routing component to build the url
 */
class RoutingExtension implements ExtensionInterface, ContainerAwareInterface
{
    /** @var  Request */
    protected $request;
    private $generator;

    /** @var  Container */
    private $container;

    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    public function buildOptions(array $options = array())
    {
        if (!empty($options['route'])) {
            $params = isset($options['routeParameters']) ? $options['routeParameters'] : array();
            $absolute = isset($options['routeAbsolute']) ? $options['routeAbsolute'] : false;
            $options['uri'] = $this->generator->generate($options['route'], $params, $absolute);
            // adding the item route to the extras under the 'routes' key (for the Silex RouteVoter)
            $options['extras']['routes'][] = array(
                'route' => $options['route'],
                'parameters' => $params,
            );
            if (isset($options['has_child']) && ($options['has_child'])) {
                if (strpos(rtrim($this->request->getRequestUri(), '/'), $options['uri']) === 0) {
                    $options['current'] = true;
                }
            }
        }

        return $options;
    }

    public function buildItem(ItemInterface $item, array $options)
    {
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
        if ($this->container->has('request') && $this->container->hasScope('request') && $this->container->isScopeActive('request')) {
            $this->request = $this->container->get('request');
        }
    }
}
