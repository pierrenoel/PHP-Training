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
        // Init the helper
        $helper = $this->getHelper("question");

        // Questions
        $question = new Question('What is the name of the field : ');

        // Show the question
        $one = $helper->ask($input,$output,$question);

        // Create the file
        touch('models/'.$input->getArgument('name').'.php');

        // Create an array
        $array = [$one];

        // Write in this file
        $this->writeIntoTheFile('models/'.$input->getArgument('name').'.php',$input->getArgument('name'));

        return Command::SUCCESS;
    }

    private function writeIntoTheFile(string $path, string $filename)
    {
        $file = fopen($path, 'w');
        $content = "<?php namespace app\models;" . PHP_EOL . PHP_EOL . "class $filename {" . PHP_EOL . PHP_EOL . "}";
        fwrite($file, $content);
        fclose($file);
    }

    private function access(array $data)
    {

    }
}