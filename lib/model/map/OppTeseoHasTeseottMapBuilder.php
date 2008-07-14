<?php



class OppTeseoHasTeseottMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppTeseoHasTeseottMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_teseo_has_teseott');
		$tMap->setPhpName('OppTeseoHasTeseott');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('OPP_TESEO_ID', 'OppTeseoId', 'int' , CreoleTypes::INTEGER, 'opp_teseo', 'ID', true, null);

		$tMap->addForeignPrimaryKey('OPP_TESEOTT_ID', 'OppTeseottId', 'int' , CreoleTypes::INTEGER, 'opp_teseott', 'ID', true, null);

	} 
} 