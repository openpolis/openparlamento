<?php



class OppTeseoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppTeseoMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_teseo');
		$tMap->setPhpName('OppTeseo');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignPrimaryKey('TIPO_TESEO_ID', 'TipoTeseoId', 'int' , CreoleTypes::INTEGER, 'opp_tipo_teseo', 'ID', true, null);

		$tMap->addColumn('DENOMINAZIONE', 'Denominazione', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('NS_DENOMINAZIONE', 'NsDenominazione', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addForeignPrimaryKey('TESEOTT_ID', 'TeseottId', 'int' , CreoleTypes::INTEGER, 'opp_teseott', 'ID', true, null);

		$tMap->addColumn('TT', 'Tt', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 