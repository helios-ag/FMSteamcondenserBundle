<?php

namespace FM\SteamcondenserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use FM\SteamcondenserBundle\Condenser\SourceServer;

/**
 * This class contains Rcon (Remote Console) command executor
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 * @author Al Ganiev <helios.ag@gmail.com>
 * @copyright 2012 Al Ganiev
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class RconCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('steam:rcon')
            ->setDescription('Rcon shell')
            ->addArgument(
                'server',
                InputArgument::REQUIRED,
                'If set, the task will execute rcon console command on selected server, otherwise localhost will be used (127.0.0.1)'
            )
            ->addArgument(
                'cmd',
                InputArgument::REQUIRED,
                'Enter command to send to server'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $input->getArgument('cmd');
        $servername =  $input->getArgument('server');
        $serverList = $this->getContainer()->getParameter('fm_steamcondenser.server_list');

        $server = new SourceServer($serverList[$servername]['address']);
        $server->initialize();
        try {
            $server->rconAuth($serverList[$servername]['password']);

            $result = $server->rconExec($command);
            $output->writeln($result);
        }
        catch(\RCONNoAuthException $e) {
            trigger_error('Could not authenticate with the game server.',
                E_USER_ERROR);
        }
    }
}