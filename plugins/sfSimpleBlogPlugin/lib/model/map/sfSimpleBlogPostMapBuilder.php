<?php



class sfSimpleBlogPostMapBuilder {

	
	const CLASS_NAME = 'plugins.sfSimpleBlogPlugin.lib.model.map.sfSimpleBlogPostMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_blog_post');
		$tMap->setPhpName('sfSimpleBlogPost');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('AUTHOR_ID', 'AuthorId', 'int', CreoleTypes::INTEGER, 'opp_user', 'ID', false, null);

		$tMap->addColumn('TITLE', 'Title', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('STRIPPED_TITLE', 'StrippedTitle', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('EXTRACT', 'Extract', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('CONTENT', 'Content', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('IS_PUBLISHED', 'IsPublished', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('ALLOW_COMMENTS', 'AllowComments', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('PUBLISHED_AT', 'PublishedAt', 'int', CreoleTypes::DATE, false, null);

	} 
} 