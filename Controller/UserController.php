<?php
namespace FM\SteamcondenserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use FM\SteamcondenserBundle\Condenser\SteamId;

/**
 * This class contains User controller, provides different user information
 *
 * @author Al Ganiev <helios.ag@gmail.com>
 * @copyright 2012 Al Ganiev
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class UserController extends Controller
{
    /**
     * Returns array of games owned by user
     * @param $username
     * @param null $pattern
     * @return array
     */
    public function listGames($username, $pattern = null)
    {
        $id = SteamID::create($username);
        $games = $id->getGames();
        return $games;
    }

    /**
     * @param $username
     * @param $game
     * @return array
     */
    public function hoursPlayed($username, $game)
    {
        $id = SteamID::create($username);
        $stats = $id->getGameStats('tf2');
        return $stats->getHoursPlayed();
    }

}
