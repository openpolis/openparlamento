<?php



class OppPolicyMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppPolicyMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_policy');
		$tMap->setPhpName('OppPolicy');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('TITOLO', 'Titolo', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('DESCRIZIONE', 'Descrizione', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('PROVVISORIA', 'Provvisoria', 'boolean', CreoleTypes::BOOLEAN, false, null);

	} 
} 