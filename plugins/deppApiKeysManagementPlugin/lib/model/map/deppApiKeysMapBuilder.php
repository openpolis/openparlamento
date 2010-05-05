<?php



class deppApiKeysMapBuilder {

	
	const CLASS_NAME = 'plugins.deppApiKeysManagementPlugin.lib.model.map.deppApiKeysMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('depp_api_keys');
		$tMap->setPhpName('deppApiKeys');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('REQ_NAME', 'ReqName', 'string', CreoleTypes::VARCHAR, true, 128);

		$tMap->addColumn('REQ_CONTACT', 'ReqContact', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('REQ_DESCRIPTION', 'ReqDescription', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('VALUE', 'Value', 'string', CreoleTypes::VARCHAR, true, 64);

		$tMap->addColumn('REQUESTED_AT', 'RequestedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('GRANTED_AT', 'GrantedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('REVOKED_AT', 'RevokedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('REFUSED_AT', 'RefusedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 