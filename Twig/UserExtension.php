<?php

namespace FM\SteamcondenserBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use FM\SteamcondenserBundle\Condenser\GoldSourceServer;
use FM\SteamcondenserBundle\Condenser\SourceServer;
use FM\SteamcondenserBundle\Condenser\SteamId;
/**
 * @author Al Ganiev <helios.ag@gmail.com>
 * @copyright 2012 Al Ganiev
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class UserExtension extends \Twig_Extension
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

    public function renderUserInfo($steamid,$showgames)
    {
        $error = '';
        try {
            $user = new SteamId($steamid);
        }
        catch(\Exception $e)
        {
            $error = 'Error: '.$e->getMessage();
        }

        return $this->container->get('twig')->render('FMSteamcondenserBundle:Widgets:UserInfo.html.twig',array('user'=>$user,'error'=>$error, 'showGames'=>$showgames));
    }

    public function getFunctions()
    {
        return array(
            'steam_user' => new \Twig_Function_Method($this, 'renderUserInfo', array('is_safe' => array('html'))),
        );
    }

    public function getName()
    {
        return 'steam_user';
    }
}