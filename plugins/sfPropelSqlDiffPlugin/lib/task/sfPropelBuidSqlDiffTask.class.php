<?php

require_once(dirname(__FILE__).'/../dbInfo.php');

class sfPropelBuildSqlDiffTask extends sfPropelBaseTask
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
    
    $this->aliases = array('propel-build-sql-diff');
    $this->namespace = 'propel';
    $this->name = 'build-sql-diff';
    $this->briefDescription = 'Creates SQL patch for the current model';

    $this->detailedDescription = <<<EOF
The [propel:build-sql-diff|INFO] task will generate diff.sql file, 
which contains difference beetween schema.yml and current database structure.

  [./symfony propel:build-sql-diff frontend|INFO]
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $buildSql = new sfPropelBuildSqlTask($this->dispatcher, $this->formatter);
    $buildSql->setCommandApplication($this->commandApplication);
    $buildSql->run();

    $this->logSection("propel-diff", "building database patch");

    $configuration = ProjectConfiguration::getApplicationConfiguration($arguments['application'], $options['env'], true);
    $databaseManager = new sfDatabaseManager($configuration);
    
    $i = new dbInfo();
    $i->loadFromDb();

    $i2 = new dbInfo();
    $i2->loadAllFilesInDir(sfConfig::get('sf_data_dir').'/sql');
    $diff = $i->getDiffWith($i2);

    $filename = sfConfig::get('sf_data_dir').'/sql/diff.sql';
    if($diff=='') {
      $this->logSection("propel-diff", "no difference found");
    }
    $this->logSection('propel-sql-diff', "writing file $filename");
    file_put_contents($filename, $diff);

  }
}

?>