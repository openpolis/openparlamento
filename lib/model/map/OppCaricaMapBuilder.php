<?php



class OppCaricaMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppCaricaMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_carica');
		$tMap->setPhpName('OppCarica');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignPrimaryKey('POLITICO_ID', 'PoliticoId', 'int' , CreoleTypes::INTEGER, 'opp_politico', 'ID', true, null);

		$tMap->addForeignPrimaryKey('TIPO_CARICA_ID', 'TipoCaricaId', 'int' , CreoleTypes::INTEGER, 'opp_tipo_carica', 'ID', true, null);

		$tMap->addColumn('CARICA', 'Carica', 'string', CreoleTypes::VARCHAR, false, 30);

		$tMap->addColumn('DATA_INIZIO', 'DataInizio', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('DATA_FINE', 'DataFine', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('LEGISLATURA', 'Legislatura', 'int', CreoleTypes::TINYINT, false, null);

		$tMap->addColumn('CIRCOSCRIZIONE', 'Circoscrizione', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('PRESENZE', 'Presenze', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('ASSENZE', 'Assenze', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('MISSIONI', 'Missioni', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('PARLIAMENT_ID', 'ParliamentId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('INDICE', 'Indice', 'double', CreoleTypes::FLOAT, false, null);

		$tMap->addColumn('SCAGLIONE', 'Scaglione', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('POSIZIONE', 'Posizione', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('MEDIA', 'Media', 'double', CreoleTypes::FLOAT, false, null);

	} 
} 