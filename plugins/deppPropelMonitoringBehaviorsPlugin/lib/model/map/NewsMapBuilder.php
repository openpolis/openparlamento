<?php



class NewsMapBuilder {

	
	const CLASS_NAME = 'plugins.deppPropelMonitoringBehaviorsPlugin.lib.model.map.NewsMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('propel');

		$tMap = $this->dbMap->addTable('sf_news_cache');
		$tMap->setPhpName('News');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('GENERATOR_MODEL', 'GeneratorModel', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('GENERATOR_ID', 'GeneratorId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('RELATED_MONITORABLE_MODEL', 'RelatedMonitorableModel', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('RELATED_MONITORABLE_ID', 'RelatedMonitorableId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('DATE', 'Date', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('PRIORITY', 'Priority', 'int', CreoleTypes::INTEGER, true, null);

	} 
} 