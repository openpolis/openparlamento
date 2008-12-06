<?php



class NewsMapBuilder {

	
	const CLASS_NAME = 'plugins.deppPropelMonitoringBehaviorsPlugin.lib.model.map.NewsMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_news_cache');
		$tMap->setPhpName('News');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('GENERATOR_MODEL', 'GeneratorModel', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('GENERATOR_PRIMARY_KEYS', 'GeneratorPrimaryKeys', 'string', CreoleTypes::VARCHAR, false, 512);

		$tMap->addColumn('RELATED_MONITORABLE_MODEL', 'RelatedMonitorableModel', 'string', CreoleTypes::VARCHAR, true, 50);

		$tMap->addColumn('RELATED_MONITORABLE_ID', 'RelatedMonitorableId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('DATE', 'Date', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('PRIORITY', 'Priority', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('TIPO_ATTO_ID', 'TipoAttoId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('DATA_PRESENTAZIONE_ATTO', 'DataPresentazioneAtto', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('RAMO_VOTAZIONE', 'RamoVotazione', 'string', CreoleTypes::CHAR, false, 1);

		$tMap->addColumn('SEDE_INTERVENTO_ID', 'SedeInterventoId', 'int', CreoleTypes::INTEGER, false, null);

	} 
} 