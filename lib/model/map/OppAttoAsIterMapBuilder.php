<?php



class OppAttoAsIterMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppAttoAsIterMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_atto_as_iter');
		$tMap->setPhpName('OppAttoAsIter');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('ATTO_ID', 'AttoId', 'int' , CreoleTypes::INTEGER, 'opp_atto', 'ID', true, null);

		$tMap->addForeignPrimaryKey('ITER_ID', 'IterId', 'int' , CreoleTypes::INTEGER, 'opp_iter', 'ID', true, null);

		$tMap->addColumn('DATA', 'Data', 'int', CreoleTypes::DATE, false, null);

	} 
} 