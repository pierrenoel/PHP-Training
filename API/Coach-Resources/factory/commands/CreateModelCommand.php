<?php

namespace app\factory\commands;

use app\helpers\StringHelper;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'make:model',description: 'Generate a new model')]
class CreateModelCommand extends Command
{
    protected function configure() : void
    {
        $this->addArgument('name',InputArgument::REQUIRED, 'The username of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $array = [];

        $io->title('Process to make a new model');

        $count = $io->ask('Number of fields in your table',1,function($count){
            if (!is_numeric($count)) {
                throw new \RuntimeException('You must type a number.');
            }

            return (int) $count;
        });

        // Ask question to get the name of the field and the type of the filed
        // Store into an array
        for($i = 0; $i < $count; $i++)
        {

            $fieldname = $io->ask('Name of the field : ','Name',function($fieldname){
                if (!is_string($fieldname)) {
                    throw new \RuntimeException('You must type a string.');
                }

                return (string) $fieldname;
            });

            $fieldtype = $io->ask('Type of the field : ','string',function($fieldtype){
                if (!is_string($fieldtype)) {
                    throw new \RuntimeException('You must type a string.');
                }

                return (string) $fieldtype;
            });

            $io->text("==================================");

            $array[$fieldname] = $fieldtype;
        }

        // Create a new file Model
        $this->model('models/'.$input->getArgument('name').'.php',$input->getArgument('name'),$array);

        // Create a new file repository
        $this->repository('repositories/'.$input->getArgument('name').'Repository.php',$input->getArgument('name'));

        return Command::SUCCESS;
    }


    private function repository(string $path, string $filename)
    {
        $content = "";

        $modelToPlural = strtolower(StringHelper::plural($filename));

        $file = fopen($path, 'w');

        $content .= "<?php " . PHP_EOL;

        $content .= PHP_EOL . "namespace app\\repositories;";

        $content .= PHP_EOL. "use app\database\ORM;" . PHP_EOL;

        $content .= "class ".$filename."Repository extends ORM";

        $content .= PHP_EOL . "{" . PHP_EOL;

        $content .= "\t protected string \$table = '$modelToPlural';";

        $content .= PHP_EOL . "}";

        fwrite($file, $content);

        fclose($file);
    }

    private function model(string $path, string $filename, array $array): void
    {
        $content = "";

        $file = fopen($path, 'w');
        $content .= "<?php " . PHP_EOL . PHP_EOL. "namespace app\models;" . PHP_EOL . PHP_EOL . "class $filename \t{" . PHP_EOL . PHP_EOL ;

        // Here we have the attributes
        $content .= $this->attributes($array);

        // Here we have the getters
        $content .= $this->getter($array);

        // Here we have the setters
        $content .= $this->setter($array);

        $content .= PHP_EOL . "}";

        fwrite($file, $content);

        fclose($file);
    }

    private function attributes(array $array): string
    {
        $content = "";

        foreach($array as $value => $key)
        {
            $value = strtolower($value);

            $content .= " \t protected $key $$value;" . PHP_EOL;

            $content .= PHP_EOL;
        }

        return $content;
    }

    public function getter(array $array) : string
    {
        $content = "";

        foreach($array as $value => $key)
        {
            $valueUc = ucfirst($value);
            $valueLc = strtolower($value);

            $content .= "\t public function get$valueUc() : $key " .PHP_EOL;

            $content .= "\t { " . PHP_EOL;

            $content .= "\t\t return \$this->$valueLc; " .PHP_EOL;

            $content .= "\t } " . PHP_EOL;

            $content .= PHP_EOL;
        }

        return $content;
    }

    public function setter(array $array) : string
    {
        $content = "";

        foreach($array as $value => $key)
        {
            $valueUc = ucfirst($value);
            $valueLc = strtolower($value);

            $content .= "\t public function set$valueUc($key \$$valueLc) : self " .PHP_EOL;

            $content .= "\t { " . PHP_EOL;

            $content .= "\t\t \$this->$valueLc = \$$valueLc; " .PHP_EOL;

            $content .= PHP_EOL . "\t\t return \$this->self; " .PHP_EOL;

            $content .= "\t } " . PHP_EOL;

            $content .= PHP_EOL;
        }

        return $content;
    }

}