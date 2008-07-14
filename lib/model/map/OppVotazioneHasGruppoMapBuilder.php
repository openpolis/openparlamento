<?php



class OppVotazioneHasGruppoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppVotazioneHasGruppoMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_votazione_has_gruppo');
		$tMap->setPhpName('OppVotazioneHasGruppo');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('VOTAZIONE_ID', 'VotazioneId', 'int' , CreoleTypes::INTEGER, 'opp_votazione', 'ID', true, null);

		$tMap->addForeignPrimaryKey('GRUPPO_ID', 'GruppoId', 'int' , CreoleTypes::INTEGER, 'opp_gruppo', 'ID', true, null);

		$tMap->addColumn('VOTO', 'Voto', 'string', CreoleTypes::VARCHAR, false, 40);

	} 
} 