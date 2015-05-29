<?php

namespace Akuma\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AkumaCoreExtension extends AbstractExtension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('twig.yml');
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');
        foreach ($bundles as $bundle => $class) {
            if (method_exists($this, 'prepend' . $bundle)) {
                call_user_func_array(array($this, 'prepend' . $bundle), array($container));
            }
        }
    }

    public function prependDoctrineBundle(ContainerBuilder $container)
    {
        $config = array(
            'orm' => array(
                'dql' => array(
                    'numeric_functions' => array(
                        'Rand' => 'Akuma\Bundle\CoreBundle\Doctrine\DQL\RandFunction',
                    )
                )
            )
        );


        $bundles = $container->getParameter('kernel.bundles');
        if (isset($bundles['DoctrineBundle'])) {
            foreach ($container->getExtensions() as $name => $extension) {
                switch ($name) {
                    case 'doctrine':
                        $container->prependExtensionConfig($name, $config);
                        break;
                }
            }
        }
    }

    protected function prependAsseticBundle(ContainerBuilder $container)
    {
        if (class_exists('Braincrafted\Bundle\BootstrapBundle\DependencyInjection\Configuration')) {
            $configs = $container->getExtensionConfig('braincrafted_bootstrap');
            $config = $this->processConfiguration(new \Braincrafted\Bundle\BootstrapBundle\DependencyInjection\Configuration(), $configs);
            if (isset($config['auto_configure']) && isset($config['auto_configure']['assetic']) && ($config['auto_configure']['assetic'])) {
                foreach (array_keys($container->getExtensions()) as $name) {
                    switch ($name) {
                        case 'assetic':
                            $asseticConfig = new AsseticConfiguration;
                            $container->prependExtensionConfig(
                                $name,
                                array('assets' => $asseticConfig->build($config))
                            );
                            break;
                    }
                }
            }
        }
    }
}
