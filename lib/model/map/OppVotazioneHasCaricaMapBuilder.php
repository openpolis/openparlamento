<?php



class OppVotazioneHasCaricaMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppVotazioneHasCaricaMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_votazione_has_carica');
		$tMap->setPhpName('OppVotazioneHasCarica');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('VOTAZIONE_ID', 'VotazioneId', 'int' , CreoleTypes::INTEGER, 'opp_votazione', 'ID', true, null);

		$tMap->addForeignPrimaryKey('CARICA_ID', 'CaricaId', 'int' , CreoleTypes::INTEGER, 'opp_carica', 'ID', true, null);

		$tMap->addColumn('VOTO', 'Voto', 'string', CreoleTypes::VARCHAR, false, 40);

	} 
} 