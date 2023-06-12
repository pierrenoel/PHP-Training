<?php

namespace app\factory\commands;

use app\helpers\StringHelper;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'make:controller',description: 'Generate a new controller')]
class CreateControllerCommand extends Command
{
    protected function configure() : void
    {
        $this->addArgument('name',InputArgument::REQUIRED, 'The name of the controller.');
    }
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Process to make a new controller');

        $controller = $io->ask('Name of the controller : ','Name',function($controller){
            if (!is_string($controller)) {
                throw new \RuntimeException('You must type a string.');
            }

            return (string) $controller;
        });

        // Create the file and write into it

        return Command::SUCCESS;
    }
}