<?php

namespace app\factory\commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;

#[AsCommand(name: 'make:model',description: 'Generate a new model')]
class CreateModelCommand extends Command
{
    protected function configure() : void
    {
        $this->addArgument('name',InputArgument::REQUIRED, 'The username of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        // TODO: Generate automatically models of the app

        return Command::SUCCESS;
    }
}