<?php

namespace FM\SteamcondenserBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use FM\SteamcondenserBundle\Condenser\GoldSourceServer;
use FM\SteamcondenserBundle\Condenser\SourceServer;

/**
 * @author Al Ganiev <helios.ag@gmail.com>
 * @copyright 2012 Al Ganiev
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class ServerExtension extends \Twig_Extension
{
    private $container;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container A container.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function renderSteamServer($ip, $port, $isSource, $showPlayers = true)
    {
        $error = '';
        try {
            $server = $isSource ? new SourceServer($ip,$port): new GoldSourceServer($ip,$port);
            $server->initialize();
        }
        catch(\Exception $e) {
                $error = 'Error: '.$e->getMessage();
        }
        return $this->container->get('twig')->render('FMSteamcondenserBundle:Widgets:ServerInfo.html.twig',array('server'=>$server,'showPlayers'=>$showPlayers,'error'=>$error));
    }

    public function getFunctions()
    {
        return array(
            'steam_server' => new \Twig_Function_Method($this, 'renderSteamServer', array('is_safe' => array('html'))),
        );
    }

    public function getName()
    {
        return 'steam_server';
    }
}