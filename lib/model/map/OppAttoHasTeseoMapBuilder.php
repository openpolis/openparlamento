<?php



class OppAttoHasTeseoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppAttoHasTeseoMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_atto_has_teseo');
		$tMap->setPhpName('OppAttoHasTeseo');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('ATTO_ID', 'AttoId', 'int' , CreoleTypes::INTEGER, 'opp_atto', 'ID', true, null);

		$tMap->addForeignPrimaryKey('TESEO_ID', 'TeseoId', 'int' , CreoleTypes::INTEGER, 'opp_teseo', 'ID', true, null);

	} 
} 