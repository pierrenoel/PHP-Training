<?php

namespace app\factory\commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'make:controller',description: 'Generate a new controller')]
class CreateControllerCommand extends Command
{
    protected function configure() : void
    {
        //$this->addArgument('name',InputArgument::REQUIRED, 'The name of the controller.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('Process to make a new controller');

        $controller = $io->ask('Name of the controller : ','Post',function($controller){

            if (!is_string($controller)) throw new \RuntimeException('You must type a string.');
            if (file_exists('controllers/'.$controller.'Controller.php')) throw new \RuntimeException('File already exists');

            return (string) $controller;
        });

        $model = $io->ask('Name of the model : ','Post',function($model){

            if (!is_string($model)) throw new \RuntimeException('You must type a string.');

            if (!file_exists('models/'.ucfirst($model).'.php')) throw new \RuntimeException('File does not exist');

            return (string) $model;
        });

        // Create the file and write into it
        $this->controller('controllers/'.ucfirst($controller).'Controller.php',ucfirst($model), ucfirst($controller));

        // Text
        $io->success("The controller has been created!");

        return Command::SUCCESS;
    }

    private function controller(string $path, string $model,$controller) : void
    {
        $content = "";

        $repository_name = $model."Repository";

        $file = fopen($path,"w");

        $content .= "<?php " . PHP_EOL;

        $content .= PHP_EOL ."namespace app\\controllers;" . PHP_EOL;

        $content .= PHP_EOL. "use app\\repositories\\".$repository_name.";" . PHP_EOL;

        $content .= PHP_EOL. "class " .$controller."Controller extends Controller";

        $content .= PHP_EOL . "{" . PHP_EOL;

        // Attributes
        $content .= "\t protected " .$model."Repository $".strtolower($model)."Repository;" . PHP_EOL;

        // Construct
        $content .= "\t public function __construct()" . PHP_EOL;
        $content .= "\t {" . PHP_EOL;
        $content .= "\t \t parent::__construct();". PHP_EOL;
        $content .= "\t \t \$this->" . strtolower($model)."Repository = new " . $repository_name . '();' . PHP_EOL;
        $content .= "\t }" . PHP_EOL;

        $content .= PHP_EOL . "}";

        fwrite($file, $content);

        fclose($file);
    }
}