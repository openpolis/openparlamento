<?php



class OppCaricaHasDdlMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppCaricaHasDdlMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_carica_has_ddl');
		$tMap->setPhpName('OppCaricaHasDdl');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('DDL_ID', 'DdlId', 'int' , CreoleTypes::INTEGER, 'opp_ddl', 'ID', true, null);

		$tMap->addForeignPrimaryKey('CARICA_ID', 'CaricaId', 'int' , CreoleTypes::INTEGER, 'opp_carica', 'ID', true, null);

		$tMap->addColumn('TIPO', 'Tipo', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('DATA', 'Data', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('URL', 'Url', 'string', CreoleTypes::LONGVARCHAR, false, null);

	} 
} 