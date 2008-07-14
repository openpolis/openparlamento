<?php



class OppDdlMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppDdlMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_ddl');
		$tMap->setPhpName('OppDdl');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('PARLAMENTO_ID', 'ParlamentoId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('TIPO', 'Tipo', 'int', CreoleTypes::TINYINT, false, null);

		$tMap->addColumn('RAMO', 'Ramo', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('NUMFASE', 'Numfase', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('LEGISLATURA', 'Legislatura', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('DATA_PRES', 'DataPres', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('DATA_AGG', 'DataAgg', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('TITOLO', 'Titolo', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('INIZIATIVA', 'Iniziativa', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('COMPLETO', 'Completo', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('DESCRIZIONE', 'Descrizione', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('SEDUTA', 'Seduta', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('ITER', 'Iter', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('DATA_ITER', 'DataIter', 'int', CreoleTypes::DATE, false, null);

	} 
} 