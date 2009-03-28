<?php


abstract class BaseCommunityNewsPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sf_community_news_cache';

	
	const CLASS_DEFAULT = 'plugins.deppPropelMonitoringBehaviorsPlugin.lib.model.CommunityNews';

	
	const NUM_COLUMNS = 10;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'sf_community_news_cache.ID';

	
	const CREATED_AT = 'sf_community_news_cache.CREATED_AT';

	
	const GENERATOR_MODEL = 'sf_community_news_cache.GENERATOR_MODEL';

	
	const GENERATOR_PRIMARY_KEYS = 'sf_community_news_cache.GENERATOR_PRIMARY_KEYS';

	
	const RELATED_MODEL = 'sf_community_news_cache.RELATED_MODEL';

	
	const RELATED_ID = 'sf_community_news_cache.RELATED_ID';

	
	const USERNAME = 'sf_community_news_cache.USERNAME';

	
	const TYPE = 'sf_community_news_cache.TYPE';

	
	const VOTE = 'sf_community_news_cache.VOTE';

	
	const TOTAL = 'sf_community_news_cache.TOTAL';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'CreatedAt', 'GeneratorModel', 'GeneratorPrimaryKeys', 'RelatedModel', 'RelatedId', 'Username', 'Type', 'Vote', 'Total', ),
		BasePeer::TYPE_COLNAME => array (CommunityNewsPeer::ID, CommunityNewsPeer::CREATED_AT, CommunityNewsPeer::GENERATOR_MODEL, CommunityNewsPeer::GENERATOR_PRIMARY_KEYS, CommunityNewsPeer::RELATED_MODEL, CommunityNewsPeer::RELATED_ID, CommunityNewsPeer::USERNAME, CommunityNewsPeer::TYPE, CommunityNewsPeer::VOTE, CommunityNewsPeer::TOTAL, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'created_at', 'generator_model', 'generator_primary_keys', 'related_model', 'related_id', 'username', 'type', 'vote', 'total', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'CreatedAt' => 1, 'GeneratorModel' => 2, 'GeneratorPrimaryKeys' => 3, 'RelatedModel' => 4, 'RelatedId' => 5, 'Username' => 6, 'Type' => 7, 'Vote' => 8, 'Total' => 9, ),
		BasePeer::TYPE_COLNAME => array (CommunityNewsPeer::ID => 0, CommunityNewsPeer::CREATED_AT => 1, CommunityNewsPeer::GENERATOR_MODEL => 2, CommunityNewsPeer::GENERATOR_PRIMARY_KEYS => 3, CommunityNewsPeer::RELATED_MODEL => 4, CommunityNewsPeer::RELATED_ID => 5, CommunityNewsPeer::USERNAME => 6, CommunityNewsPeer::TYPE => 7, CommunityNewsPeer::VOTE => 8, CommunityNewsPeer::TOTAL => 9, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'created_at' => 1, 'generator_model' => 2, 'generator_primary_keys' => 3, 'related_model' => 4, 'related_id' => 5, 'username' => 6, 'type' => 7, 'vote' => 8, 'total' => 9, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'plugins/deppPropelMonitoringBehaviorsPlugin/lib/model/map/CommunityNewsMapBuilder.php';
		return BasePeer::getMapBuilder('plugins.deppPropelMonitoringBehaviorsPlugin.lib.model.map.CommunityNewsMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = CommunityNewsPeer::getTableMap();
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
		return str_replace(CommunityNewsPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(CommunityNewsPeer::ID);

		$criteria->addSelectColumn(CommunityNewsPeer::CREATED_AT);

		$criteria->addSelectColumn(CommunityNewsPeer::GENERATOR_MODEL);

		$criteria->addSelectColumn(CommunityNewsPeer::GENERATOR_PRIMARY_KEYS);

		$criteria->addSelectColumn(CommunityNewsPeer::RELATED_MODEL);

		$criteria->addSelectColumn(CommunityNewsPeer::RELATED_ID);

		$criteria->addSelectColumn(CommunityNewsPeer::USERNAME);

		$criteria->addSelectColumn(CommunityNewsPeer::TYPE);

		$criteria->addSelectColumn(CommunityNewsPeer::VOTE);

		$criteria->addSelectColumn(CommunityNewsPeer::TOTAL);

	}

	const COUNT = 'COUNT(sf_community_news_cache.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sf_community_news_cache.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(CommunityNewsPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(CommunityNewsPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = CommunityNewsPeer::doSelectRS($criteria, $con);
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
		$objects = CommunityNewsPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return CommunityNewsPeer::populateObjects(CommunityNewsPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseCommunityNewsPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseCommunityNewsPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			CommunityNewsPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = CommunityNewsPeer::getOMClass();
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
		return CommunityNewsPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseCommunityNewsPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseCommunityNewsPeer', $values, $con);
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

		$criteria->remove(CommunityNewsPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseCommunityNewsPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseCommunityNewsPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseCommunityNewsPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseCommunityNewsPeer', $values, $con);
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
			$comparison = $criteria->getComparison(CommunityNewsPeer::ID);
			$selectCriteria->add(CommunityNewsPeer::ID, $criteria->remove(CommunityNewsPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseCommunityNewsPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseCommunityNewsPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(CommunityNewsPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(CommunityNewsPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof CommunityNews) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(CommunityNewsPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(CommunityNews $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(CommunityNewsPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(CommunityNewsPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(CommunityNewsPeer::DATABASE_NAME, CommunityNewsPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = CommunityNewsPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(CommunityNewsPeer::DATABASE_NAME);

		$criteria->add(CommunityNewsPeer::ID, $pk);


		$v = CommunityNewsPeer::doSelect($criteria, $con);

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
			$criteria->add(CommunityNewsPeer::ID, $pks, Criteria::IN);
			$objs = CommunityNewsPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseCommunityNewsPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'plugins/deppPropelMonitoringBehaviorsPlugin/lib/model/map/CommunityNewsMapBuilder.php';
	Propel::registerMapBuilder('plugins.deppPropelMonitoringBehaviorsPlugin.lib.model.map.CommunityNewsMapBuilder');
}
