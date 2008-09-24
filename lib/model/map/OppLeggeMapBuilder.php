<?php



class OppLeggeMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppLeggeMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_legge');
		$tMap->setPhpName('OppLegge');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignPrimaryKey('ATTO_ID', 'AttoId', 'int' , CreoleTypes::INTEGER, 'opp_atto', 'ID', true, null);

		$tMap->addColumn('NUMERO', 'Numero', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('DATA', 'Data', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('URL', 'Url', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('GU', 'Gu', 'string', CreoleTypes::LONGVARCHAR, false, null);

	} 
} 