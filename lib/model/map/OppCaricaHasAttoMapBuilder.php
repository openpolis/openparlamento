<?php



class OppCaricaHasAttoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppCaricaHasAttoMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_carica_has_atto');
		$tMap->setPhpName('OppCaricaHasAtto');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('ATTO_ID', 'AttoId', 'int' , CreoleTypes::INTEGER, 'opp_atto', 'ID', true, null);

		$tMap->addForeignPrimaryKey('CARICA_ID', 'CaricaId', 'int' , CreoleTypes::INTEGER, 'opp_carica', 'ID', true, null);

		$tMap->addPrimaryKey('TIPO', 'Tipo', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('DATA', 'Data', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('URL', 'Url', 'string', CreoleTypes::LONGVARCHAR, false, null);

	} 
} 