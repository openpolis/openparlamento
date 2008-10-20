<?php



class sfVotingMapBuilder {

	
	const CLASS_NAME = 'plugins.deppPropelActAsVotableBehaviorPlugin.lib.model.map.sfVotingMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_votings');
		$tMap->setPhpName('sfVoting');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('VOTABLE_MODEL', 'VotableModel', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('VOTABLE_ID', 'VotableId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('VOTING', 'Voting', 'int', CreoleTypes::INTEGER, true, null);

	} 
} 