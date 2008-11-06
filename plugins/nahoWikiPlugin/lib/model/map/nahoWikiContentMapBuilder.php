<?php



class nahoWikiContentMapBuilder {

	
	const CLASS_NAME = 'plugins.nahoWikiPlugin.lib.model.map.nahoWikiContentMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('naho_wiki_content');
		$tMap->setPhpName('nahoWikiContent');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CONTENT', 'Content', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('GZ_CONTENT', 'GzContent', 'string', CreoleTypes::BLOB, false, null);

	} 
} 