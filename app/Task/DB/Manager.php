<?php

namespace Task\DB;

use Stringy\StaticStringy;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Manager extends Command
{
  protected function configure()
  {
    $this
      ->setName('db:manager')
      ->setDescription('Обновляет список коллекций приложения в менеджере БД');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $arr = array();
    $names = array();

    if (is_dir(DIR_COLLECTION)) {
      $it = new \FilesystemIterator(DIR_COLLECTION, \FilesystemIterator::SKIP_DOTS);
      while($it->valid()) {
        if (!$it->isDot() && !$it->isDir()) {
          $nm = $it->getBasename('.php');
          $cl = 'Collection\\' . $nm;
          if (class_exists($cl)) {
            $names[] = $nm;
            $arr[] = "  public function " . StaticStringy::camelize($nm) . "()\n"
              . "  {\n"
              . "    return new \\{$cl}(\$this);\n"
              . "  }";
          }
        }

        $it->next();
      }
    }

    $code = "<?php\n\nnamespace Base;\n\n"
      . "/** Этот файл сгенерирован автоматически командой db:manager */\n"
      . "class Manager extends \\SQRT\\DB\\Manager\n{\n"
      . "  function __construct()\n"
      . "  {\n"
      . "    \$this->addConnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);\n"
      . "    \$this->setPrefix(PREFIX);\n"
      . "  }\n\n"
      . join("\n\n", $arr) . "\n"
      . "}";

    $file = DIR_APP . '/Base/Manager.php';
    file_put_contents($file, $code);

    if (!empty($names)) {
      $output->writeln(sprintf('<info>Менеджер БД обновлен, список коллекций: %s</info>', join(', ', $names)));
    } else {
      $output->writeln('<info>Первичная инициализация менеджера БД</info>');
    }
  }
}