<?php

namespace Task\DB;

use SQRT\DB\Schema;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Clear extends Command
{
  protected function configure()
  {
    $this
      ->setName('db:clear')
      ->setDescription('Сброс всех таблиц');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $db = new \Base\Manager();

    $limit = 10;
    $arr = array();

    if (is_dir(DIR_SCHEMA)) {
      $it = new \FilesystemIterator(DIR_SCHEMA, \FilesystemIterator::SKIP_DOTS);
      while($it->valid()) {
        if (!$it->isDot() && !$it->isDir()) {
          $nm = $it->getBasename('.php');
          $cl = 'Schema\\' . $nm;
          if (class_exists($cl)) {
            $arr[$nm] = new $cl($db);
          }
        }

        $it->next();
      }
    }

    $db->query('DROP TABLE IF EXISTS phinxlog');

    while($limit--) {
      /** @var $schema Schema */
      foreach ($arr as $nm => $schema) {
        try {
          $db->query('DROP TABLE IF EXISTS ' . $db->getPrefix() . $schema->getTable());

          $output->writeln(sprintf('<info>Таблица %s сброшена</info>', $nm));
          unset($arr[$nm]);
        } catch (\Exception $e) {}
      }

      if (empty($arr)) {
        $output->writeln(sprintf('<info>Все таблицы сброшены.</info>'));

        break;
      }
    }
  }
}