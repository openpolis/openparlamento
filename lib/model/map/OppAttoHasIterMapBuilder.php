<?php



class OppAttoHasIterMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppAttoHasIterMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_atto_has_iter');
		$tMap->setPhpName('OppAttoHasIter');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignPrimaryKey('ATTO_ID', 'AttoId', 'int' , CreoleTypes::INTEGER, 'opp_atto', 'ID', true, null);

		$tMap->addForeignPrimaryKey('ITER_ID', 'IterId', 'int' , CreoleTypes::INTEGER, 'opp_iter', 'ID', true, null);

		$tMap->addColumn('DATA', 'Data', 'int', CreoleTypes::DATE, false, null);

	} 
} 