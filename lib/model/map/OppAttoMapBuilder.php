<?php



class OppAttoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppAttoMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_atto');
		$tMap->setPhpName('OppAtto');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('PARLAMENTO_ID', 'ParlamentoId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addForeignPrimaryKey('TIPO_ATTO_ID', 'TipoAttoId', 'int' , CreoleTypes::INTEGER, 'opp_tipo_atto', 'ID', true, null);

		$tMap->addColumn('RAMO', 'Ramo', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('NUMFASE', 'Numfase', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('LEGISLATURA', 'Legislatura', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('DATA_PRES', 'DataPres', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('DATA_AGG', 'DataAgg', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('TITOLO', 'Titolo', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('INIZIATIVA', 'Iniziativa', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('COMPLETO', 'Completo', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('DESCRIZIONE', 'Descrizione', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('SEDUTA', 'Seduta', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('PRED', 'Pred', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('SUCC', 'Succ', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 