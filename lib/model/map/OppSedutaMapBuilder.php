<?php



class OppSedutaMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppSedutaMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_seduta');
		$tMap->setPhpName('OppSeduta');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('DATA', 'Data', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('NUMERO', 'Numero', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('RAMO', 'Ramo', 'string', CreoleTypes::CHAR, true, 1);

		$tMap->addColumn('LEGISLATURA', 'Legislatura', 'int', CreoleTypes::TINYINT, true, null);

		$tMap->addColumn('URL', 'Url', 'string', CreoleTypes::VARCHAR, false, 255);

	} 
} 