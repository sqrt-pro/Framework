<?php

namespace Task\DB;

use SQRT\DB\Schema;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Migration extends Command
{
  protected function configure()
  {
    $this
      ->setName('db:migration')
      ->setDescription('Создание миграции на основе схемы')
      ->addArgument('schema', InputArgument::REQUIRED, 'Схема, по которой генерируется модель в неймспейсе Schema')
      ->addArgument('name', InputArgument::REQUIRED, 'Уникальное имя миграции');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $db = new \Base\Manager();

    $schema_name    = 'Schema\\' . $input->getArgument('schema');
    $migration_name = $input->getArgument('name');

    if (!class_exists($schema_name)) {
      $output->writeln(sprintf('<error>Схема "%s" не существует</error>', $schema_name));

      return;
    }

    /** @var $schema Schema */
    $schema = new $schema_name($db);

    if (!is_dir(DIR_MIGRATION)) {
      mkdir(DIR_MIGRATION);
    }

    $file = DIR_MIGRATION . DIRECTORY_SEPARATOR . $schema->makeMigrationName($migration_name);
    file_put_contents($file, $schema->makeMigration($migration_name));
    $output->writeln(sprintf('<info>Миграция создана: %s</info>', $file));
  }
}