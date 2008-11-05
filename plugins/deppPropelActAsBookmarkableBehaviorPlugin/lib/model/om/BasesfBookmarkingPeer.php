<?php


abstract class BasesfBookmarkingPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sf_bookmarkings';

	
	const CLASS_DEFAULT = 'plugins.deppPropelActAsBookmarkableBehaviorPlugin.lib.model.sfBookmarking';

	
	const NUM_COLUMNS = 5;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'sf_bookmarkings.ID';

	
	const BOOKMARKABLE_MODEL = 'sf_bookmarkings.BOOKMARKABLE_MODEL';

	
	const BOOKMARKABLE_ID = 'sf_bookmarkings.BOOKMARKABLE_ID';

	
	const USER_ID = 'sf_bookmarkings.USER_ID';

	
	const BOOKMARKING = 'sf_bookmarkings.BOOKMARKING';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'BookmarkableModel', 'BookmarkableId', 'UserId', 'Bookmarking', ),
		BasePeer::TYPE_COLNAME => array (sfBookmarkingPeer::ID, sfBookmarkingPeer::BOOKMARKABLE_MODEL, sfBookmarkingPeer::BOOKMARKABLE_ID, sfBookmarkingPeer::USER_ID, sfBookmarkingPeer::BOOKMARKING, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'bookmarkable_model', 'bookmarkable_id', 'user_id', 'bookmarking', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'BookmarkableModel' => 1, 'BookmarkableId' => 2, 'UserId' => 3, 'Bookmarking' => 4, ),
		BasePeer::TYPE_COLNAME => array (sfBookmarkingPeer::ID => 0, sfBookmarkingPeer::BOOKMARKABLE_MODEL => 1, sfBookmarkingPeer::BOOKMARKABLE_ID => 2, sfBookmarkingPeer::USER_ID => 3, sfBookmarkingPeer::BOOKMARKING => 4, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'bookmarkable_model' => 1, 'bookmarkable_id' => 2, 'user_id' => 3, 'bookmarking' => 4, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'plugins/deppPropelActAsBookmarkableBehaviorPlugin/lib/model/map/sfBookmarkingMapBuilder.php';
		return BasePeer::getMapBuilder('plugins.deppPropelActAsBookmarkableBehaviorPlugin.lib.model.map.sfBookmarkingMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = sfBookmarkingPeer::getTableMap();
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
		return str_replace(sfBookmarkingPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(sfBookmarkingPeer::ID);

		$criteria->addSelectColumn(sfBookmarkingPeer::BOOKMARKABLE_MODEL);

		$criteria->addSelectColumn(sfBookmarkingPeer::BOOKMARKABLE_ID);

		$criteria->addSelectColumn(sfBookmarkingPeer::USER_ID);

		$criteria->addSelectColumn(sfBookmarkingPeer::BOOKMARKING);

	}

	const COUNT = 'COUNT(sf_bookmarkings.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sf_bookmarkings.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfBookmarkingPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfBookmarkingPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = sfBookmarkingPeer::doSelectRS($criteria, $con);
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
		$objects = sfBookmarkingPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return sfBookmarkingPeer::populateObjects(sfBookmarkingPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfBookmarkingPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BasesfBookmarkingPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			sfBookmarkingPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = sfBookmarkingPeer::getOMClass();
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
		return sfBookmarkingPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfBookmarkingPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfBookmarkingPeer', $values, $con);
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

		$criteria->remove(sfBookmarkingPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BasesfBookmarkingPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasesfBookmarkingPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfBookmarkingPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfBookmarkingPeer', $values, $con);
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
			$comparison = $criteria->getComparison(sfBookmarkingPeer::ID);
			$selectCriteria->add(sfBookmarkingPeer::ID, $criteria->remove(sfBookmarkingPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasesfBookmarkingPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasesfBookmarkingPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(sfBookmarkingPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(sfBookmarkingPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof sfBookmarking) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(sfBookmarkingPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(sfBookmarking $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(sfBookmarkingPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(sfBookmarkingPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(sfBookmarkingPeer::DATABASE_NAME, sfBookmarkingPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = sfBookmarkingPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(sfBookmarkingPeer::DATABASE_NAME);

		$criteria->add(sfBookmarkingPeer::ID, $pk);


		$v = sfBookmarkingPeer::doSelect($criteria, $con);

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
			$criteria->add(sfBookmarkingPeer::ID, $pks, Criteria::IN);
			$objs = sfBookmarkingPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BasesfBookmarkingPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'plugins/deppPropelActAsBookmarkableBehaviorPlugin/lib/model/map/sfBookmarkingMapBuilder.php';
	Propel::registerMapBuilder('plugins.deppPropelActAsBookmarkableBehaviorPlugin.lib.model.map.sfBookmarkingMapBuilder');
}
