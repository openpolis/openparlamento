<?php



class SupraMapBuilder {

	
	const CLASS_NAME = 'plugins.sfSupraVariablesPlugin.lib.model.map.SupraMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_supra_variable');
		$tMap->setPhpName('Supra');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('TYPE', 'Type', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('VALUE', 'Value', 'string', CreoleTypes::LONGVARCHAR, true, null);

	} 
} 