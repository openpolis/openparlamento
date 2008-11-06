<?php



class nahoWikiRevisionMapBuilder {

	
	const CLASS_NAME = 'plugins.nahoWikiPlugin.lib.model.map.nahoWikiRevisionMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('naho_wiki_revision');
		$tMap->setPhpName('nahoWikiRevision');

		$tMap->setUseIdGenerator(false);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addForeignPrimaryKey('PAGE_ID', 'PageId', 'int' , CreoleTypes::INTEGER, 'naho_wiki_page', 'ID', true, null);

		$tMap->addPrimaryKey('REVISION', 'Revision', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('USER_NAME', 'UserName', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('COMMENT', 'Comment', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addForeignPrimaryKey('CONTENT_ID', 'ContentId', 'int' , CreoleTypes::INTEGER, 'naho_wiki_content', 'ID', true, null);

	} 
} 