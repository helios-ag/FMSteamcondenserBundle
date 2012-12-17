<?php

use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use FM\SteamcondenserBundle\Command\ListPlayersCommand;

class ListPlayersCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        // mock the Kernel or create one depending on your needs
        $application = new Application($kernel);
        $application->add(new ListPlayersCommand());

        $command = $application->find('demo:greet');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));

        $this->assertRegExp('/.../', $commandTester->getDisplay());

    // ...
    }
}