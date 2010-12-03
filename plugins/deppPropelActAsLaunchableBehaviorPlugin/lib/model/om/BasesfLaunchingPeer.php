<?php


abstract class BasesfLaunchingPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sf_launching';

	
	const CLASS_DEFAULT = 'plugins.deppPropelActAsLaunchableBehaviorPlugin.lib.model.sfLaunching';

	
	const NUM_COLUMNS = 6;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'sf_launching.ID';

	
	const OBJECT_MODEL = 'sf_launching.OBJECT_MODEL';

	
	const OBJECT_ID = 'sf_launching.OBJECT_ID';

	
	const LAUNCH_NAMESPACE = 'sf_launching.LAUNCH_NAMESPACE';

	
	const CREATED_AT = 'sf_launching.CREATED_AT';

	
	const PRIORITY = 'sf_launching.PRIORITY';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'ObjectModel', 'ObjectId', 'LaunchNamespace', 'CreatedAt', 'Priority', ),
		BasePeer::TYPE_COLNAME => array (sfLaunchingPeer::ID, sfLaunchingPeer::OBJECT_MODEL, sfLaunchingPeer::OBJECT_ID, sfLaunchingPeer::LAUNCH_NAMESPACE, sfLaunchingPeer::CREATED_AT, sfLaunchingPeer::PRIORITY, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'object_model', 'object_id', 'launch_namespace', 'created_at', 'priority', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'ObjectModel' => 1, 'ObjectId' => 2, 'LaunchNamespace' => 3, 'CreatedAt' => 4, 'Priority' => 5, ),
		BasePeer::TYPE_COLNAME => array (sfLaunchingPeer::ID => 0, sfLaunchingPeer::OBJECT_MODEL => 1, sfLaunchingPeer::OBJECT_ID => 2, sfLaunchingPeer::LAUNCH_NAMESPACE => 3, sfLaunchingPeer::CREATED_AT => 4, sfLaunchingPeer::PRIORITY => 5, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'object_model' => 1, 'object_id' => 2, 'launch_namespace' => 3, 'created_at' => 4, 'priority' => 5, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'plugins/deppPropelActAsLaunchableBehaviorPlugin/lib/model/map/sfLaunchingMapBuilder.php';
		return BasePeer::getMapBuilder('plugins.deppPropelActAsLaunchableBehaviorPlugin.lib.model.map.sfLaunchingMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = sfLaunchingPeer::getTableMap();
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
		return str_replace(sfLaunchingPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(sfLaunchingPeer::ID);

		$criteria->addSelectColumn(sfLaunchingPeer::OBJECT_MODEL);

		$criteria->addSelectColumn(sfLaunchingPeer::OBJECT_ID);

		$criteria->addSelectColumn(sfLaunchingPeer::LAUNCH_NAMESPACE);

		$criteria->addSelectColumn(sfLaunchingPeer::CREATED_AT);

		$criteria->addSelectColumn(sfLaunchingPeer::PRIORITY);

	}

	const COUNT = 'COUNT(sf_launching.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sf_launching.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfLaunchingPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfLaunchingPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = sfLaunchingPeer::doSelectRS($criteria, $con);
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
		$objects = sfLaunchingPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return sfLaunchingPeer::populateObjects(sfLaunchingPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfLaunchingPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BasesfLaunchingPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			sfLaunchingPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = sfLaunchingPeer::getOMClass();
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
		return sfLaunchingPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfLaunchingPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfLaunchingPeer', $values, $con);
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

		$criteria->remove(sfLaunchingPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BasesfLaunchingPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasesfLaunchingPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfLaunchingPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfLaunchingPeer', $values, $con);
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
			$comparison = $criteria->getComparison(sfLaunchingPeer::ID);
			$selectCriteria->add(sfLaunchingPeer::ID, $criteria->remove(sfLaunchingPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasesfLaunchingPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasesfLaunchingPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(sfLaunchingPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(sfLaunchingPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof sfLaunching) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(sfLaunchingPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(sfLaunching $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(sfLaunchingPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(sfLaunchingPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(sfLaunchingPeer::DATABASE_NAME, sfLaunchingPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = sfLaunchingPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(sfLaunchingPeer::DATABASE_NAME);

		$criteria->add(sfLaunchingPeer::ID, $pk);


		$v = sfLaunchingPeer::doSelect($criteria, $con);

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
			$criteria->add(sfLaunchingPeer::ID, $pks, Criteria::IN);
			$objs = sfLaunchingPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BasesfLaunchingPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'plugins/deppPropelActAsLaunchableBehaviorPlugin/lib/model/map/sfLaunchingMapBuilder.php';
	Propel::registerMapBuilder('plugins.deppPropelActAsLaunchableBehaviorPlugin.lib.model.map.sfLaunchingMapBuilder');
}
