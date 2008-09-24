<?php



class OppInterventoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppInterventoMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_intervento');
		$tMap->setPhpName('OppIntervento');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignPrimaryKey('ATTO_ID', 'AttoId', 'int' , CreoleTypes::INTEGER, 'opp_atto', 'ID', true, null);

		$tMap->addForeignPrimaryKey('CARICA_ID', 'CaricaId', 'int' , CreoleTypes::INTEGER, 'opp_carica', 'ID', true, null);

		$tMap->addForeignPrimaryKey('SEDE_ID', 'SedeId', 'int' , CreoleTypes::INTEGER, 'opp_sede', 'ID', true, null);

		$tMap->addColumn('TIPOLOGIA', 'Tipologia', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('URL', 'Url', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('DATA', 'Data', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('NUMERO', 'Numero', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('AP', 'Ap', 'int', CreoleTypes::TINYINT, false, null);

	} 
} 