<?php



class OppGruppoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppGruppoMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_gruppo');
		$tMap->setPhpName('OppGruppo');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NOME', 'Nome', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('ACRONIMO', 'Acronimo', 'string', CreoleTypes::VARCHAR, false, 80);

	} 
} 