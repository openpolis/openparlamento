<?php



class OppVotazioneMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.OppVotazioneMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('opp_votazione');
		$tMap->setPhpName('OppVotazione');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignPrimaryKey('SEDUTA_ID', 'SedutaId', 'int' , CreoleTypes::INTEGER, 'opp_seduta', 'ID', true, null);

		$tMap->addColumn('NUMERO_VOTAZIONE', 'NumeroVotazione', 'int', CreoleTypes::TINYINT, true, null);

		$tMap->addColumn('TITOLO', 'Titolo', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('PRESENTI', 'Presenti', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('VOTANTI', 'Votanti', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('MAGGIORANZA', 'Maggioranza', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('ASTENUTI', 'Astenuti', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('FAVOREVOLI', 'Favorevoli', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('CONTRARI', 'Contrari', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('ESITO', 'Esito', 'string', CreoleTypes::VARCHAR, false, 20);

		$tMap->addColumn('TIPOLOGIA', 'Tipologia', 'string', CreoleTypes::VARCHAR, false, 20);

		$tMap->addColumn('DESCRIZIONE', 'Descrizione', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('URL', 'Url', 'string', CreoleTypes::VARCHAR, false, 255);

	} 
} 