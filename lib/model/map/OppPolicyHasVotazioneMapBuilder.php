<?php



class OppPolicyHasVotazioneMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppPolicyHasVotazioneMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_policy_has_votazione');
		$tMap->setPhpName('OppPolicyHasVotazione');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('POLICY_ID', 'PolicyId', 'int' , CreoleTypes::INTEGER, 'opp_policy', 'ID', true, null);

		$tMap->addForeignPrimaryKey('VOTAZIONE_ID', 'VotazioneId', 'int' , CreoleTypes::INTEGER, 'opp_votazione', 'ID', true, null);

		$tMap->addColumn('VOTO', 'Voto', 'string', CreoleTypes::VARCHAR, false, 25);

		$tMap->addColumn('STRONG', 'Strong', 'boolean', CreoleTypes::BOOLEAN, false, null);

	} 
} 