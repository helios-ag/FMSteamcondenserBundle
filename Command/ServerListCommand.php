<?php

namespace FM\SteamcondenserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This class contains Rcon (Remote Console) server list defined through DI
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 * @author Al Ganiev <helios.ag@gmail.com>
 * @copyright 2012 Al Ganiev
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class ServerListCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('steam:serverlist')
            ->setDescription('steam server list defined by DI')
        ;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $serverList = $this->getContainer()->getParameter('fm_steamcondenser.server_list');
        foreach($serverList as $key => $server)
            $output->writeln($key.'=>'.$server['address'].':'.$server['port'].'@'.$server['password']);
    }
}