<?php

namespace Task\DB;

use Stringy\StaticStringy;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;

class Schema extends Command
{
  protected function configure()
  {
    $this
      ->setName('db:schema')
      ->setDescription('Создание базового класса схемы')
      ->addArgument('schema', InputArgument::REQUIRED, 'Название схемы CamelCase');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $name = $input->getArgument('schema');

    if (!is_dir(DIR_SCHEMA)) {
      mkdir(DIR_SCHEMA);
    }

    $code = "<?php\n\nnamespace Schema;\n\nuse SQRT\\DB\\Schema;\n\n"
      . "class {$name} extends Schema\n"
      . "{\n"
      . "  protected function init()\n"
      . "  {\n"
      . "    \$this->setTable('" . StaticStringy::underscored($name) . "');\n"
      . "    \$this->setName('{$name}');\n"
      . "    \$this\n"
      . "      ->addId()\n"
      . "      ->addChar('name');\n"
      . "  }\n"
      . "}";

    $file = DIR_SCHEMA . '/' . $name . '.php';
    if (file_exists($file)) {
      $output->writeln(sprintf('<error>Схема %s уже существует!</error>', $name));

      return;
    }

    file_put_contents($file, $code);
    $output->writeln(sprintf('<info>Схема %s создана: %s</info>', $name, $file));
  }
}