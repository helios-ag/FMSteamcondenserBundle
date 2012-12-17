<?php

namespace FM\SteamcondenserBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Registration of the extension via DI.
 *
 * @author Al Ganiev <helios.ag@gmail.com>
 * @copyright 2012 Al Ganiev
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class FMSteamcondenserExtension extends Extension {

    /**
     * @see Symfony\Component\DependencyInjection\Extension.ExtensionInterface::load()
     * @param array                                                   $configs
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container) {
        $config = $this->processConfiguration(new Configuration(), $configs);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('steam.xml');
        $servers = isset($config['config']['servers']) ? $config['config']['servers'] : array();

        $container->setParameter('fm_steamcondenser.server_list', $config['server_list']);
        $container->setParameter('fm_steamcondenser.goldsrc.server', $servers);

    }
}
