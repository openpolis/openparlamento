<?php



class OppPoliticoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppPoliticoMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_politico');
		$tMap->setPhpName('OppPolitico');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NOME', 'Nome', 'string', CreoleTypes::VARCHAR, false, 30);

		$tMap->addColumn('COGNOME', 'Cognome', 'string', CreoleTypes::VARCHAR, false, 30);

	} 
} 