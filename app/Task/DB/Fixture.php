<?php

namespace Task\DB;

use SQRT\DB\Schema;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Fixture extends Command
{
  protected function configure()
  {
    $this
      ->setName('db:fixture')
      ->setDescription('Заполнение таблицы данными по-умолчанию из схемы')
      ->addArgument('schema', InputArgument::REQUIRED, 'Схема');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $db = new \Base\Manager();

    $schema_name = 'Schema\\' . $input->getArgument('schema');

    if (!class_exists($schema_name)) {
      $output->writeln(sprintf('<error>Схема "%s" не существует</error>', $schema_name));

      return;
    }

    /** @var $schema Schema */
    $schema = new $schema_name($db);

    try {
      $schema->fixture();

      $output->writeln(sprintf('<info>Данные схемы "%s" успешно загружены</info>', $schema_name));
    } catch (\Exception $e) {
      $output->writeln(
        sprintf(
          '<error>Ошибка при загрузке фикстур для схемы "%s": [%s] %s</error>',
          $schema_name,
          $e->getCode(),
          $e->getMessage()
        )
      );
    }
  }
}