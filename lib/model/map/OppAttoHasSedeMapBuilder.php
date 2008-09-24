<?php



class OppAttoHasSedeMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppAttoHasSedeMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_atto_has_sede');
		$tMap->setPhpName('OppAttoHasSede');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('ATTO_ID', 'AttoId', 'int' , CreoleTypes::INTEGER, 'opp_atto', 'ID', true, null);

		$tMap->addForeignPrimaryKey('SEDE_ID', 'SedeId', 'int' , CreoleTypes::INTEGER, 'opp_sede', 'ID', true, null);

		$tMap->addColumn('TIPO', 'Tipo', 'string', CreoleTypes::VARCHAR, false, 255);

	} 
} 