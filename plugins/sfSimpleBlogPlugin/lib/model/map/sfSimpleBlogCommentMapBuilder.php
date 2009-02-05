<?php



class sfSimpleBlogCommentMapBuilder {

	
	const CLASS_NAME = 'plugins.sfSimpleBlogPlugin.lib.model.map.sfSimpleBlogCommentMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_blog_comment');
		$tMap->setPhpName('sfSimpleBlogComment');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('SF_BLOG_POST_ID', 'SfBlogPostId', 'int', CreoleTypes::INTEGER, 'sf_blog_post', 'ID', false, null);

		$tMap->addColumn('AUTHOR_NAME', 'AuthorName', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('AUTHOR_EMAIL', 'AuthorEmail', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('AUTHOR_URL', 'AuthorUrl', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CONTENT', 'Content', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('IS_MODERATED', 'IsModerated', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 