<?php

namespace FM\SteamcondenserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class contains the configuration information for the bundle
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 * @author Al Ganiev <helios.ag@gmail.com>
 * @copyright 2012 Al Ganiev
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fm_steamcondenser', 'array');

        $rootNode
            ->children()
                ->arrayNode('server_list')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('address')
                                ->defaultValue('127.0.0.1')
                                ->info('ip address of rcon server')
                                ->example('127.0.0.1')
                            ->end()
                            ->scalarNode('port')
                                ->defaultValue('27015')
                                ->info('ip address port')
                                ->example('27015 (default port for CS)')
                            ->end()
                            ->scalarNode('password')
                                ->defaultValue('passw0rd')
                                ->info('server password')
                                ->example('passw0rd')
                            ->end()
                            ->scalarNode('source')
                                ->defaultValue('false')
                                ->info('source based server?')
                                ->example('true')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
