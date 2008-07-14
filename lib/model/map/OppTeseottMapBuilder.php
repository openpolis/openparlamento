<?php



class OppTeseottMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppTeseottMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_teseott');
		$tMap->setPhpName('OppTeseott');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('DENOMINAZIONE', 'Denominazione', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('NS_DENOMINAZIONE', 'NsDenominazione', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('TESEO_SENATO', 'TeseoSenato', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 