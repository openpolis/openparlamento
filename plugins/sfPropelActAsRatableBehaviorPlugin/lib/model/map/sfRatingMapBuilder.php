<?php



class sfRatingMapBuilder {

	
	const CLASS_NAME = 'plugins.sfPropelActAsRatableBehaviorPlugin.lib.model.map.sfRatingMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_ratings');
		$tMap->setPhpName('sfRating');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('RATABLE_MODEL', 'RatableModel', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('RATABLE_ID', 'RatableId', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('USER_ID', 'UserId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('RATING', 'Rating', 'int', CreoleTypes::INTEGER, true, null);

	} 
} 