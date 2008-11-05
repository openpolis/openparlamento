<?php



class sfBookmarkingMapBuilder {

	
	const CLASS_NAME = 'plugins.deppPropelActAsBookmarkableBehaviorPlugin.lib.model.map.sfBookmarkingMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_bookmarkings');
		$tMap->setPhpName('sfBookmarking');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('BOOKMARKABLE_MODEL', 'BookmarkableModel', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('BOOKMARKABLE_ID', 'BookmarkableId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('BOOKMARKING', 'Bookmarking', 'int', CreoleTypes::INTEGER, true, null);

	} 
} 