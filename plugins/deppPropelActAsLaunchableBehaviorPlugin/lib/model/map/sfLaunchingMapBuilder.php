<?php



class sfLaunchingMapBuilder {

	
	const CLASS_NAME = 'plugins.deppPropelActAsLaunchableBehaviorPlugin.lib.model.map.sfLaunchingMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_launching');
		$tMap->setPhpName('sfLaunching');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('OBJECT_MODEL', 'ObjectModel', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('OBJECT_ID', 'ObjectId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAMESPACE', 'Namespace', 'string', CreoleTypes::VARCHAR, true, 100);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('PRIORITY', 'Priority', 'int', CreoleTypes::INTEGER, true, null);

	} 
} 