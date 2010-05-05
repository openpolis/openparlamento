<?php


abstract class BasedeppApiKeysPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'depp_api_keys';

	
	const CLASS_DEFAULT = 'plugins.deppApiKeysManagementPlugin.lib.model.deppApiKeys';

	
	const NUM_COLUMNS = 9;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'depp_api_keys.ID';

	
	const REQ_NAME = 'depp_api_keys.REQ_NAME';

	
	const REQ_CONTACT = 'depp_api_keys.REQ_CONTACT';

	
	const REQ_DESCRIPTION = 'depp_api_keys.REQ_DESCRIPTION';

	
	const VALUE = 'depp_api_keys.VALUE';

	
	const REQUESTED_AT = 'depp_api_keys.REQUESTED_AT';

	
	const GRANTED_AT = 'depp_api_keys.GRANTED_AT';

	
	const REVOKED_AT = 'depp_api_keys.REVOKED_AT';

	
	const REFUSED_AT = 'depp_api_keys.REFUSED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'ReqName', 'ReqContact', 'ReqDescription', 'Value', 'RequestedAt', 'GrantedAt', 'RevokedAt', 'RefusedAt', ),
		BasePeer::TYPE_COLNAME => array (deppApiKeysPeer::ID, deppApiKeysPeer::REQ_NAME, deppApiKeysPeer::REQ_CONTACT, deppApiKeysPeer::REQ_DESCRIPTION, deppApiKeysPeer::VALUE, deppApiKeysPeer::REQUESTED_AT, deppApiKeysPeer::GRANTED_AT, deppApiKeysPeer::REVOKED_AT, deppApiKeysPeer::REFUSED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'req_name', 'req_contact', 'req_description', 'value', 'requested_at', 'granted_at', 'revoked_at', 'refused_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'ReqName' => 1, 'ReqContact' => 2, 'ReqDescription' => 3, 'Value' => 4, 'RequestedAt' => 5, 'GrantedAt' => 6, 'RevokedAt' => 7, 'RefusedAt' => 8, ),
		BasePeer::TYPE_COLNAME => array (deppApiKeysPeer::ID => 0, deppApiKeysPeer::REQ_NAME => 1, deppApiKeysPeer::REQ_CONTACT => 2, deppApiKeysPeer::REQ_DESCRIPTION => 3, deppApiKeysPeer::VALUE => 4, deppApiKeysPeer::REQUESTED_AT => 5, deppApiKeysPeer::GRANTED_AT => 6, deppApiKeysPeer::REVOKED_AT => 7, deppApiKeysPeer::REFUSED_AT => 8, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'req_name' => 1, 'req_contact' => 2, 'req_description' => 3, 'value' => 4, 'requested_at' => 5, 'granted_at' => 6, 'revoked_at' => 7, 'refused_at' => 8, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'plugins/deppApiKeysManagementPlugin/lib/model/map/deppApiKeysMapBuilder.php';
		return BasePeer::getMapBuilder('plugins.deppApiKeysManagementPlugin.lib.model.map.deppApiKeysMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = deppApiKeysPeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(deppApiKeysPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(deppApiKeysPeer::ID);

		$criteria->addSelectColumn(deppApiKeysPeer::REQ_NAME);

		$criteria->addSelectColumn(deppApiKeysPeer::REQ_CONTACT);

		$criteria->addSelectColumn(deppApiKeysPeer::REQ_DESCRIPTION);

		$criteria->addSelectColumn(deppApiKeysPeer::VALUE);

		$criteria->addSelectColumn(deppApiKeysPeer::REQUESTED_AT);

		$criteria->addSelectColumn(deppApiKeysPeer::GRANTED_AT);

		$criteria->addSelectColumn(deppApiKeysPeer::REVOKED_AT);

		$criteria->addSelectColumn(deppApiKeysPeer::REFUSED_AT);

	}

	const COUNT = 'COUNT(depp_api_keys.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT depp_api_keys.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(deppApiKeysPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(deppApiKeysPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = deppApiKeysPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}
	
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = deppApiKeysPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return deppApiKeysPeer::populateObjects(deppApiKeysPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BasedeppApiKeysPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BasedeppApiKeysPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			deppApiKeysPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = deppApiKeysPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}
	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return deppApiKeysPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasedeppApiKeysPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasedeppApiKeysPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(deppApiKeysPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BasedeppApiKeysPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasedeppApiKeysPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasedeppApiKeysPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasedeppApiKeysPeer', $values, $con);
      if (false !== $ret)
      {
        return $ret;
      }
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(deppApiKeysPeer::ID);
			$selectCriteria->add(deppApiKeysPeer::ID, $criteria->remove(deppApiKeysPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasedeppApiKeysPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasedeppApiKeysPeer', $values, $con, $ret);
    }

    return $ret;
  }

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 		try {
									$con->begin();
			$affectedRows += BasePeer::doDeleteAll(deppApiKeysPeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(deppApiKeysPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof deppApiKeys) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(deppApiKeysPeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public static function doValidate(deppApiKeys $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(deppApiKeysPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(deppApiKeysPeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(deppApiKeysPeer::DATABASE_NAME, deppApiKeysPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = deppApiKeysPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(deppApiKeysPeer::DATABASE_NAME);

		$criteria->add(deppApiKeysPeer::ID, $pk);


		$v = deppApiKeysPeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(deppApiKeysPeer::ID, $pks, Criteria::IN);
			$objs = deppApiKeysPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BasedeppApiKeysPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'plugins/deppApiKeysManagementPlugin/lib/model/map/deppApiKeysMapBuilder.php';
	Propel::registerMapBuilder('plugins.deppApiKeysManagementPlugin.lib.model.map.deppApiKeysMapBuilder');
}
