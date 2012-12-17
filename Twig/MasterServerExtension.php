<?php

namespace FM\SteamcondenserBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use FM\SteamcondenserBundle\Condenser\GoldSourceServer;
use FM\SteamcondenserBundle\Condenser\SourceServer;

/**
 * @to be implemented
 * @author Al Ganiev <helios.ag@gmail.com>
 * @copyright 2012 Al Ganiev
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class MasterServerExtension extends \Twig_Extension
{
    public function getName()
    {
        return 'fm_steam_masterserver';
    }
}