<?php

namespace FM\SteamcondenserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use FM\SteamcondenserBundle\Condenser\SteamId;

/**
 * This class contains Rcon (Remote Console) command executor
 *
 * This information is solely responsible for how the different configuration
 * sections are normalized, and merged.
 * @author Al Ganiev <helios.ag@gmail.com>
 * @copyright 2012 Al Ganiev
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class UserInfoCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('steam:userinfo')
            ->setDescription('steam user information, including ')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Enter steam name or steam ID'
            )
            ->addOption(
                'showgames',
                null,
                InputOption::VALUE_NONE,
                'List Users Games'
        )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name =  $input->getArgument('name');
        $id = SteamID::create($name);
        $status = $id->isOnline() ? 'Online': 'Offline';
        $output->writeln("Current user nickname: <info>".$id->getNickname().'</info>, user is: <info>'.$status.'</info>');
        if($input->getOption('showgames'))
        {
            $games = $id->getGames();
            foreach($games as $gameId => $game)
                $output->writeln('['.$gameId.'] '.$game->getName());
        }
    }
}