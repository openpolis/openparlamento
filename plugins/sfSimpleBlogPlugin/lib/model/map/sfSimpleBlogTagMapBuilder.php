<?php



class sfSimpleBlogTagMapBuilder {

	
	const CLASS_NAME = 'plugins.sfSimpleBlogPlugin.lib.model.map.sfSimpleBlogTagMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('sf_blog_tag');
		$tMap->setPhpName('sfSimpleBlogTag');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('SF_BLOG_POST_ID', 'SfBlogPostId', 'int' , CreoleTypes::INTEGER, 'sf_blog_post', 'ID', true, null);

		$tMap->addPrimaryKey('TAG', 'Tag', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 