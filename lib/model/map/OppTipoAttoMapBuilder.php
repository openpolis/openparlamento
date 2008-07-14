<?php



class OppTipoAttoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppTipoAttoMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_tipo_atto');
		$tMap->setPhpName('OppTipoAtto');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('DENOMINAZIONE', 'Denominazione', 'string', CreoleTypes::VARCHAR, false, 60);

	} 
} 