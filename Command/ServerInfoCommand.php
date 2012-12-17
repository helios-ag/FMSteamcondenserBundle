<?php

namespace FM\SteamcondenserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\HelperInterface;
use FM\SteamcondenserBundle\Condenser\GoldSourceServer;
use FM\SteamcondenserBundle\Condenser\SourceServer;
/**
 *
 * @author Al Ganiev <helios.ag@gmail.com>
 * @copyright 2012 Al Ganiev
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class ServerInfoCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('steam:serverinfo')
            ->setDescription('display basic information about server')
            ->addArgument(
                'server',
                InputArgument::OPTIONAL,
                'server alias defined in config.yml'
            )
            ->addOption(
            'showplayers',
            null,
            InputOption::VALUE_NONE,
            'show current players on server'
        )
            ->addOption(
               'ip',
                null,
                InputOption::VALUE_REQUIRED,
                'ip address'
        )
            ->addOption(
                'port',
                null,
                InputOption::VALUE_OPTIONAL,
                'port, if not specified, 27015 will be used'
        )
        ;
    }

    /**
     * @param $ip
     * @param int $port
     * @param bool $isSource
     * @return \FM\SteamcondenserBundle\Condenser\GoldSourceServer|\FM\SteamcondenserBundle\Condenser\SourceServer
     */
    protected function initializeServer($ip,$port = 27015,$isSource = true)
    {
        return $server = $isSource ? new SourceServer($ip,$port): new GoldSourceServer($ip,$port);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $isSource = false;
        if($servername = $input->getArgument('server')){
            $serverList = $this->getContainer()->getParameter('fm_steamcondenser.server_list');
            $serverIp = $serverList[$servername]['address'];
            $serverPort = $serverList[$servername]['port'];
            $server = $this->initializeServer($serverIp,$serverPort,$serverList[$servername]['source']);
            }
        else {
            if($input->getOption('ip')){
                $dialog = $this->getHelperSet()->get('dialog');
                if(!$dialog->askConfirmation(
                        $output,
                        '<question>Is server you specified SOURCE based?</question>',
                        false
                    ))
                    $isSource = true;
                    ;
                $serverPort = $input->getOption('port') =='' ? 27015 : $input->getOption('port');
                $serverIp = $input->getOption('ip');
                $server = $this->initializeServer($serverIp, $serverPort, $isSource);
            }
            else {
                $output->writeln('<info>Server not specified. Exiting</info>');
                return;
            }

        };
        $server->initialize();
        $serverinfo = $server->getServerInfo();
        $output->writeln('<info>Server name:</info> '.$serverinfo['serverName']);
        $output->writeln('<info>Server ip:port</info> '.$serverIp.':'.$serverPort);
        $output->writeln('<info>Game:</info> '.$serverinfo['gameDesc']);
        $output->writeln('<info>Players:</info> '.$serverinfo['numberOfPlayers'].'/'.$serverinfo['maxPlayers']);
        $output->writeln('<info>Ping:</info> '.$server->getPing().' ms');
        if($input->getOption('showplayers'))
        {
            $output->writeln('<info>Current players on server</info>');
            foreach($server->getPlayers() as $player)
                $output->writeln('<info>'.$player->getName().'</info> Score:'.$player->getScore());
        }
    }
}

