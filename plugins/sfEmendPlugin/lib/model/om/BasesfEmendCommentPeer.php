<?php


abstract class BasesfEmendCommentPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sf_emend_comment';

	
	const CLASS_DEFAULT = 'plugins.sfEmendPlugin.lib.model.sfEmendComment';

	
	const NUM_COLUMNS = 9;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'sf_emend_comment.ID';

	
	const URL = 'sf_emend_comment.URL';

	
	const SELECTION = 'sf_emend_comment.SELECTION';

	
	const TITLE = 'sf_emend_comment.TITLE';

	
	const BODY = 'sf_emend_comment.BODY';

	
	const AUTHOR_ID = 'sf_emend_comment.AUTHOR_ID';

	
	const AUTHOR_NAME = 'sf_emend_comment.AUTHOR_NAME';

	
	const CREATED_AT = 'sf_emend_comment.CREATED_AT';

	
	const IS_PUBLIC = 'sf_emend_comment.IS_PUBLIC';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Url', 'Selection', 'Title', 'Body', 'AuthorId', 'AuthorName', 'CreatedAt', 'IsPublic', ),
		BasePeer::TYPE_COLNAME => array (sfEmendCommentPeer::ID, sfEmendCommentPeer::URL, sfEmendCommentPeer::SELECTION, sfEmendCommentPeer::TITLE, sfEmendCommentPeer::BODY, sfEmendCommentPeer::AUTHOR_ID, sfEmendCommentPeer::AUTHOR_NAME, sfEmendCommentPeer::CREATED_AT, sfEmendCommentPeer::IS_PUBLIC, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'url', 'selection', 'title', 'body', 'author_id', 'author_name', 'created_at', 'is_public', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Url' => 1, 'Selection' => 2, 'Title' => 3, 'Body' => 4, 'AuthorId' => 5, 'AuthorName' => 6, 'CreatedAt' => 7, 'IsPublic' => 8, ),
		BasePeer::TYPE_COLNAME => array (sfEmendCommentPeer::ID => 0, sfEmendCommentPeer::URL => 1, sfEmendCommentPeer::SELECTION => 2, sfEmendCommentPeer::TITLE => 3, sfEmendCommentPeer::BODY => 4, sfEmendCommentPeer::AUTHOR_ID => 5, sfEmendCommentPeer::AUTHOR_NAME => 6, sfEmendCommentPeer::CREATED_AT => 7, sfEmendCommentPeer::IS_PUBLIC => 8, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'url' => 1, 'selection' => 2, 'title' => 3, 'body' => 4, 'author_id' => 5, 'author_name' => 6, 'created_at' => 7, 'is_public' => 8, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'plugins/sfEmendPlugin/lib/model/map/sfEmendCommentMapBuilder.php';
		return BasePeer::getMapBuilder('plugins.sfEmendPlugin.lib.model.map.sfEmendCommentMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = sfEmendCommentPeer::getTableMap();
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
		return str_replace(sfEmendCommentPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(sfEmendCommentPeer::ID);

		$criteria->addSelectColumn(sfEmendCommentPeer::URL);

		$criteria->addSelectColumn(sfEmendCommentPeer::SELECTION);

		$criteria->addSelectColumn(sfEmendCommentPeer::TITLE);

		$criteria->addSelectColumn(sfEmendCommentPeer::BODY);

		$criteria->addSelectColumn(sfEmendCommentPeer::AUTHOR_ID);

		$criteria->addSelectColumn(sfEmendCommentPeer::AUTHOR_NAME);

		$criteria->addSelectColumn(sfEmendCommentPeer::CREATED_AT);

		$criteria->addSelectColumn(sfEmendCommentPeer::IS_PUBLIC);

	}

	const COUNT = 'COUNT(sf_emend_comment.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sf_emend_comment.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfEmendCommentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfEmendCommentPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = sfEmendCommentPeer::doSelectRS($criteria, $con);
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
		$objects = sfEmendCommentPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return sfEmendCommentPeer::populateObjects(sfEmendCommentPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfEmendCommentPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BasesfEmendCommentPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			sfEmendCommentPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = sfEmendCommentPeer::getOMClass();
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
		return sfEmendCommentPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfEmendCommentPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfEmendCommentPeer', $values, $con);
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

		$criteria->remove(sfEmendCommentPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BasesfEmendCommentPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasesfEmendCommentPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfEmendCommentPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfEmendCommentPeer', $values, $con);
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
			$comparison = $criteria->getComparison(sfEmendCommentPeer::ID);
			$selectCriteria->add(sfEmendCommentPeer::ID, $criteria->remove(sfEmendCommentPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasesfEmendCommentPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasesfEmendCommentPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(sfEmendCommentPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(sfEmendCommentPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof sfEmendComment) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(sfEmendCommentPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(sfEmendComment $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(sfEmendCommentPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(sfEmendCommentPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(sfEmendCommentPeer::DATABASE_NAME, sfEmendCommentPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = sfEmendCommentPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(sfEmendCommentPeer::DATABASE_NAME);

		$criteria->add(sfEmendCommentPeer::ID, $pk);


		$v = sfEmendCommentPeer::doSelect($criteria, $con);

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
			$criteria->add(sfEmendCommentPeer::ID, $pks, Criteria::IN);
			$objs = sfEmendCommentPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BasesfEmendCommentPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'plugins/sfEmendPlugin/lib/model/map/sfEmendCommentMapBuilder.php';
	Propel::registerMapBuilder('plugins.sfEmendPlugin.lib.model.map.sfEmendCommentMapBuilder');
}
