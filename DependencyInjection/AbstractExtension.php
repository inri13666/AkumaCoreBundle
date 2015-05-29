<?php
/**
 * User  : Nikita.Makarov
 * Date  : 5/29/15
 * Time  : 5:47 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\CoreBundle\DependencyInjection;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

abstract class AbstractExtension extends Extension{
    protected function createConfigEntries(array $config, ContainerBuilder $container, $parent = null)
    {
        $isScalar = true;
        foreach ($config as $key => $value) {
            if (!is_numeric($key)) {
                $isScalar = false;
                break;
            }
        }
        if ($isScalar) {
            if (!is_null($parent)) {
                $container->setParameter($parent, $config);
            }
        } else {
            foreach ($config as $key => $value) {
                if (is_array($value)) {
                    $keys = array_keys($value);
                    $this->createConfigEntries($value, $container, $parent ? $parent . '.' . $key : $key);
                } else {
                    $container->setParameter($parent ? $parent . '.' . $key : $key, $value);
                }
            }
        }
    }
} 