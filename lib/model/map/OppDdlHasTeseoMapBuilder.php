<?php



class OppDdlHasTeseoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppDdlHasTeseoMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_ddl_has_teseo');
		$tMap->setPhpName('OppDdlHasTeseo');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('DDL_ID', 'DdlId', 'int' , CreoleTypes::INTEGER, 'opp_ddl', 'ID', true, null);

		$tMap->addForeignPrimaryKey('TESEO_ID', 'TeseoId', 'int' , CreoleTypes::INTEGER, 'opp_teseo', 'ID', true, null);

	} 
} 