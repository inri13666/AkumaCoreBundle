<?php
/**
 * User  : Nikita.Makarov
 * Date  : 2/3/15
 * Time  : 6:39 AM
 * E-Mail: nikita.makarov@effective-soft.com
 */

namespace Akuma\Bundle\CoreBundle\DependencyInjection;


class AsseticConfiguration
{
    /**
     * Builds the assetic configuration.
     *
     * @param array $config
     *
     * @return array
     */
    public function build(array $config)
    {
        $output = array();

        if (is_readable($config['assets_dir'] . '/dist/css/bootstrap.css.map')) {
            // Fix path in output dir
            if ('/' !== substr($config['output_dir'], -1) && strlen($config['output_dir']) > 0) {
                $config['output_dir'] .= '/';
            }
            $output['bootstrap_css_map'] = array(
                'inputs' => array(
                    $config['assets_dir'] . '/dist/css/bootstrap.css.map'
                ),
                'filters' => array(),
                'output' => $config['output_dir'] . 'css/bootstrap.css.map'
            );
        }
        return $output;
    }
} 