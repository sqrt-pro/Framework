<?php

namespace Task\DB;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;

class Model extends Command
{
  protected function configure()
  {
    $this
      ->setName('db:model')
      ->setDescription('Создание объектов Collection и Item на основе схемы')
      ->addArgument('schema', InputArgument::REQUIRED, 'Схема, по которой генерируется модель в неймспейсе Schema');
    $this->addOption('skip-collection', 'c', InputOption::VALUE_NONE, 'Пропустить генерацию Collection');
    $this->addOption('skip-item', 'i', InputOption::VALUE_NONE, 'Пропустить генерацию Item');
    $this->addOption('skip-manager', 'm', InputOption::VALUE_NONE, 'Не обновлять Manager');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $cmd_mgr = $this->getApplication()->find('db:manager');

    $skip_coll = $input->getOption('skip-collection');
    $skip_item = $input->getOption('skip-item');
    $skip_mngr = $input->getOption('skip-manager');

    // Если менеджер еще не существует, создаем его и подключаем
    if (!class_exists('\Base\Manager')) {
      $cmd_mgr->run(new ArrayInput(array('command' => 'db:manager')), $output);

      require_once DIR_ORM . '/Base/Manager.php';
    }

    $db = new \Base\Manager();

    $schema_name = 'Schema\\' . $input->getArgument('schema');

    if (!class_exists($schema_name)) {
      $output->writeln(sprintf('<error>Схема "%s" не существует</error>', $schema_name));

      return;
    }

    /** @var $schema \SQRT\DB\Schema */
    $schema = new $schema_name($db);

    // Коллекция
    if (empty($skip_coll)) {
      if (!is_dir(DIR_COLLECTION)) {
        mkdir(DIR_COLLECTION);
      }

      $class = $schema->getName();
      $file  = DIR_COLLECTION . DIRECTORY_SEPARATOR . $schema->getName() . '.php';
      if (!file_exists($file)) {
        file_put_contents($file, $schema->makeCollection());
        $output->writeln(sprintf('<info>Collection\\%s создан: %s</info>', $class, $file));
      } else {
        $output->writeln(sprintf('<info>Класс Collection\\%s уже существует: %s</info>', $class, $file));
      }
    }

    // Базовый ORM класс
    if (empty($skip_item)) {
      if (!is_dir(DIR_ORM)) {
        mkdir(DIR_ORM);
      }

      $class = $schema->getItemClass(false);
      $file  = DIR_ORM . DIRECTORY_SEPARATOR . $class . '.php';
      file_put_contents($file, $schema->makeItem());
      $output->writeln(sprintf('<info>ORM\\%s создан: %s</info>', $class, $file));

      // Базовый класс модели
      $file = DIR_APP . DIRECTORY_SEPARATOR . $class . '.php';
      if (!file_exists($file)) {
        $code = "<?php\n\nuse ORM\\{$class} as BaseItem;\n\nclass {$class} extends BaseItem\n{\n\n}";
        file_put_contents($file, $code);
        $output->writeln(sprintf('<info>Базовый класс \\%s создан: %s</info>', $class, $file));
      }
    }

    // Обновляем менеджера
    if (empty($skip_mngr)) {
      $cmd_mgr->run(new ArrayInput(array('command' => 'db:manager')), $output);
    }
  }
}