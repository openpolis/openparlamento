<?php



class sfEmendCommentMapBuilder {

	
	const CLASS_NAME = 'plugins.sfEmendPlugin.lib.model.map.sfEmendCommentMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_emend_comment');
		$tMap->setPhpName('sfEmendComment');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('URL', 'Url', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('SELECTION', 'Selection', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('BODY', 'Body', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('AUTHOR_ID', 'AuthorId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('AUTHOR_NAME', 'AuthorName', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('IS_PUBLIC', 'IsPublic', 'int', CreoleTypes::TINYINT, true, null);

	} 
} 