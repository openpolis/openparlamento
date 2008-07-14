<?php



class OppMappingMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppMappingMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_mapping');
		$tMap->setPhpName('OppMapping');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('POLITICO_ID', 'PoliticoId', 'int' , CreoleTypes::INTEGER, 'opp_politico', 'ID', true, null);

		$tMap->addPrimaryKey('PARLIAMENT_ID', 'ParliamentId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('LEGISLATURA', 'Legislatura', 'int', CreoleTypes::TINYINT, true, null);

	} 
} 