<?php

require_once(dirname(__FILE__).'/../dbInfo.php');

class sfPropelInsertSqlDiffTask extends sfPropelBaseTask
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

    $this->aliases = array('propel-insert-sql-diff');
    $this->namespace = 'propel';
    $this->name = 'insert-sql-diff';
    $this->briefDescription = 'Inserts SQL patch for the current model';

    $this->detailedDescription = <<<EOF
The [propel:insert-sql-diff|INFO] task will connect to database and execute diff.sql file, 
which contains difference beetween schema.yml and current database structure.
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $buildSql = new sfPropelBuildSqlDiffTask($this->dispatcher, $this->formatter);
    $buildSql->setCommandApplication($this->commandApplication);
    $buildSql->execute($arguments, $options);

    $filename = sfConfig::get('sf_data_dir').'/sql/diff.sql';
    $this->logSection("propel-diff", "executing file $filename");
    $i = new dbInfo();
    $i->executeSql(file_get_contents($filename));
  }
}

?>