<?php



class nahoWikiPageMapBuilder {

	
	const CLASS_NAME = 'plugins.nahoWikiPlugin.lib.model.map.nahoWikiPageMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('naho_wiki_page');
		$tMap->setPhpName('nahoWikiPage');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('LATEST_REVISION', 'LatestRevision', 'int', CreoleTypes::INTEGER, true, null);

	} 
} 