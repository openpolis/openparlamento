<?php



class OppVotazioneHasAttoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppVotazioneHasAttoMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_votazione_has_atto');
		$tMap->setPhpName('OppVotazioneHasAtto');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('VOTAZIONE_ID', 'VotazioneId', 'int' , CreoleTypes::INTEGER, 'opp_votazione', 'ID', true, null);

		$tMap->addForeignPrimaryKey('ATTO_ID', 'AttoId', 'int' , CreoleTypes::INTEGER, 'opp_atto', 'ID', true, null);

	} 
} 