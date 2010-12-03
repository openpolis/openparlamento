<?php



class sfCommentMapBuilder {

	
	const CLASS_NAME = 'plugins.deppPropelActAsCommentableBehaviorPlugin.lib.model.map.sfCommentMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_comment');
		$tMap->setPhpName('sfComment');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('COMMENTABLE_MODEL', 'CommentableModel', 'string', CreoleTypes::VARCHAR, false, 30);

		$tMap->addColumn('COMMENTABLE_ID', 'CommentableId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('COMMENT_NAMESPACE', 'CommentNamespace', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('TEXT', 'Text', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('AUTHOR_ID', 'AuthorId', 'int', CreoleTypes::INTEGER, false, null);

		$tMap->addColumn('AUTHOR_NAME', 'AuthorName', 'string', CreoleTypes::VARCHAR, false, 50);

		$tMap->addColumn('AUTHOR_EMAIL', 'AuthorEmail', 'string', CreoleTypes::VARCHAR, false, 100);

		$tMap->addColumn('AUTHOR_WEBSITE', 'AuthorWebsite', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('IS_PUBLIC', 'IsPublic', 'int', CreoleTypes::TINYINT, true, null);

	} 
} 