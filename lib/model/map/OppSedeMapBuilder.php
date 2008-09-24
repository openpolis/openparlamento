<?php



class OppSedeMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppSedeMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_sede');
		$tMap->setPhpName('OppSede');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('RAMO', 'Ramo', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('DENOMINAZIONE', 'Denominazione', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('LEGISLATURA', 'Legislatura', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('TIPOLOGIA', 'Tipologia', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CODICE', 'Codice', 'string', CreoleTypes::VARCHAR, false, 255);

	} 
} 