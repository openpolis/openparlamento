<?php



class CommunityNewsMapBuilder {

	
	const CLASS_NAME = 'plugins.deppPropelMonitoringBehaviorsPlugin.lib.model.map.CommunityNewsMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_community_news_cache');
		$tMap->setPhpName('CommunityNews');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('GENERATOR_MODEL', 'GeneratorModel', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('GENERATOR_PRIMARY_KEYS', 'GeneratorPrimaryKeys', 'string', CreoleTypes::VARCHAR, false, 512);

		$tMap->addColumn('RELATED_MODEL', 'RelatedModel', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('RELATED_ID', 'RelatedId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('USERNAME', 'Username', 'string', CreoleTypes::VARCHAR, false, 128);

		$tMap->addColumn('TYPE', 'Type', 'string', CreoleTypes::CHAR, false, 1);

		$tMap->addColumn('VOTE', 'Vote', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('TOTAL', 'Total', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 