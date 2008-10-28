<?php



class MonitoringMapBuilder {

	
	const CLASS_NAME = 'plugins.deppPropelActAsMonitorableBehaviorPlugin.lib.model.map.MonitoringMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_monitoring');
		$tMap->setPhpName('Monitoring');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('MONITORABLE_MODEL', 'MonitorableModel', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('MONITORABLE_ID', 'MonitorableId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 