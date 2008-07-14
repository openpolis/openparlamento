<?php



class OppLegislaturaHasGruppoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppLegislaturaHasGruppoMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_legislatura_has_gruppo');
		$tMap->setPhpName('OppLegislaturaHasGruppo');

		$tMap->setUseIdGenerator(false);

		$tMap->addPrimaryKey('LEGISLATURA', 'Legislatura', 'int', CreoleTypes::TINYINT, true, null);

		$tMap->addPrimaryKey('RAMO', 'Ramo', 'string', CreoleTypes::CHAR, true, 1);

		$tMap->addForeignPrimaryKey('GRUPPO_ID', 'GruppoId', 'int' , CreoleTypes::INTEGER, 'opp_gruppo', 'ID', true, null);

	} 
} 