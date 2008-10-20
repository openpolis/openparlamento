<?php

require_once(dirname(__FILE__).'/../dbInfo.php');

class sfPropelBuildAllDiffTask extends sfPropelBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('application', sfCommandArgument::REQUIRED, 'The application name'),
    ));

    $this->addOptions(array(
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
    ));
    
    $this->aliases = array('propel-build-all-diff');
    $this->namespace = 'propel';
    $this->name = 'build-all-diff';
    $this->briefDescription = 'Generates Propel model, and updates database without losing data';

    $this->detailedDescription = <<<EOF
Generates Propel model, and updates database structure without losing data
 
The task is equivalent to:

  [./symfony propel:insert-sql-diff|INFO]
  [./symfony propel:build-model|INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $task = new sfPropelInsertSqlDiffTask($this->dispatcher, $this->formatter);
    $task->setCommandApplication($this->commandApplication);
    $task->execute($arguments, $options);

    $task = new sfPropelBuildModelTask($this->dispatcher, $this->formatter);
    $task->setCommandApplication($this->commandApplication);
    $task->execute();
  }
}

?>