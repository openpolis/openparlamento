<?php



class OppCaricaHasGruppoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppCaricaHasGruppoMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_carica_has_gruppo');
		$tMap->setPhpName('OppCaricaHasGruppo');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('CARICA_ID', 'CaricaId', 'int' , CreoleTypes::INTEGER, 'opp_carica', 'ID', true, null);

		$tMap->addForeignPrimaryKey('GRUPPO_ID', 'GruppoId', 'int' , CreoleTypes::INTEGER, 'opp_gruppo', 'ID', true, null);

		$tMap->addColumn('DATA_INIZIO', 'DataInizio', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('DATA_FINE', 'DataFine', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('RIBELLE', 'Ribelle', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 