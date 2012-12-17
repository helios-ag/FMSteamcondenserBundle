<?php

namespace FM\SteamcondenserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use FM\SteamcondenserBundle\Condenser\GoldSourceServer;
/**
 * This class contains Rcon (Remote Console) command executor
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 * @author Al Ganiev <helios.ag@gmail.com>
 * @copyright 2012 Al Ganiev
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class ListPlayersCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('steam:players')
            ->setDescription('show players list on selected server')
            ->addArgument(
                'server',
                InputArgument::REQUIRED,
                'server alias defined in config.yml'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $servername =  $input->getArgument('server');
        $serverList = $this->getContainer()->getParameter('fm_steamcondenser.server_list');
        $server = new GoldSourceServer($serverList[$servername]['address'],$serverList[$servername]['port']);
        $server->initialize();
        $players = $server->getPlayers();

        foreach($players as $player)
            $output->writeln('<info>Player'.$player->getName().'</info> Score:<comment>'.$player->getScore().'</comment>');
    }
}