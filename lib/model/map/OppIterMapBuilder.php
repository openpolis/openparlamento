<?php



class OppIterMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppIterMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_iter');
		$tMap->setPhpName('OppIter');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('FASE', 'Fase', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CONCLUSO', 'Concluso', 'boolean', CreoleTypes::BOOLEAN, false, null);

	} 
} 