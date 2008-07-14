<?php



class OppAppoggioMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppAppoggioMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_appoggio');
		$tMap->setPhpName('OppAppoggio');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignPrimaryKey('CARICA_ID', 'CaricaId', 'int' , CreoleTypes::INTEGER, 'opp_carica', 'ID', true, null);

		$tMap->addColumn('AKA', 'Aka', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('TIPOLOGIA', 'Tipologia', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('LEGISLATURA', 'Legislatura', 'int', CreoleTypes::TINYINT, false, null);

	} 
} 