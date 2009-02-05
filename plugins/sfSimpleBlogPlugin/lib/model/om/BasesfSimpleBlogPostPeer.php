<?php


abstract class BasesfSimpleBlogPostPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sf_blog_post';

	
	const CLASS_DEFAULT = 'plugins.sfSimpleBlogPlugin.lib.model.sfSimpleBlogPost';

	
	const NUM_COLUMNS = 10;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'sf_blog_post.ID';

	
	const AUTHOR_ID = 'sf_blog_post.AUTHOR_ID';

	
	const TITLE = 'sf_blog_post.TITLE';

	
	const STRIPPED_TITLE = 'sf_blog_post.STRIPPED_TITLE';

	
	const EXTRACT = 'sf_blog_post.EXTRACT';

	
	const CONTENT = 'sf_blog_post.CONTENT';

	
	const IS_PUBLISHED = 'sf_blog_post.IS_PUBLISHED';

	
	const ALLOW_COMMENTS = 'sf_blog_post.ALLOW_COMMENTS';

	
	const CREATED_AT = 'sf_blog_post.CREATED_AT';

	
	const PUBLISHED_AT = 'sf_blog_post.PUBLISHED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'AuthorId', 'Title', 'StrippedTitle', 'Extract', 'Content', 'IsPublished', 'AllowComments', 'CreatedAt', 'PublishedAt', ),
		BasePeer::TYPE_COLNAME => array (sfSimpleBlogPostPeer::ID, sfSimpleBlogPostPeer::AUTHOR_ID, sfSimpleBlogPostPeer::TITLE, sfSimpleBlogPostPeer::STRIPPED_TITLE, sfSimpleBlogPostPeer::EXTRACT, sfSimpleBlogPostPeer::CONTENT, sfSimpleBlogPostPeer::IS_PUBLISHED, sfSimpleBlogPostPeer::ALLOW_COMMENTS, sfSimpleBlogPostPeer::CREATED_AT, sfSimpleBlogPostPeer::PUBLISHED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'author_id', 'title', 'stripped_title', 'extract', 'content', 'is_published', 'allow_comments', 'created_at', 'published_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'AuthorId' => 1, 'Title' => 2, 'StrippedTitle' => 3, 'Extract' => 4, 'Content' => 5, 'IsPublished' => 6, 'AllowComments' => 7, 'CreatedAt' => 8, 'PublishedAt' => 9, ),
		BasePeer::TYPE_COLNAME => array (sfSimpleBlogPostPeer::ID => 0, sfSimpleBlogPostPeer::AUTHOR_ID => 1, sfSimpleBlogPostPeer::TITLE => 2, sfSimpleBlogPostPeer::STRIPPED_TITLE => 3, sfSimpleBlogPostPeer::EXTRACT => 4, sfSimpleBlogPostPeer::CONTENT => 5, sfSimpleBlogPostPeer::IS_PUBLISHED => 6, sfSimpleBlogPostPeer::ALLOW_COMMENTS => 7, sfSimpleBlogPostPeer::CREATED_AT => 8, sfSimpleBlogPostPeer::PUBLISHED_AT => 9, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'author_id' => 1, 'title' => 2, 'stripped_title' => 3, 'extract' => 4, 'content' => 5, 'is_published' => 6, 'allow_comments' => 7, 'created_at' => 8, 'published_at' => 9, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'plugins/sfSimpleBlogPlugin/lib/model/map/sfSimpleBlogPostMapBuilder.php';
		return BasePeer::getMapBuilder('plugins.sfSimpleBlogPlugin.lib.model.map.sfSimpleBlogPostMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = sfSimpleBlogPostPeer::getTableMap();
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
		return str_replace(sfSimpleBlogPostPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(sfSimpleBlogPostPeer::ID);

		$criteria->addSelectColumn(sfSimpleBlogPostPeer::AUTHOR_ID);

		$criteria->addSelectColumn(sfSimpleBlogPostPeer::TITLE);

		$criteria->addSelectColumn(sfSimpleBlogPostPeer::STRIPPED_TITLE);

		$criteria->addSelectColumn(sfSimpleBlogPostPeer::EXTRACT);

		$criteria->addSelectColumn(sfSimpleBlogPostPeer::CONTENT);

		$criteria->addSelectColumn(sfSimpleBlogPostPeer::IS_PUBLISHED);

		$criteria->addSelectColumn(sfSimpleBlogPostPeer::ALLOW_COMMENTS);

		$criteria->addSelectColumn(sfSimpleBlogPostPeer::CREATED_AT);

		$criteria->addSelectColumn(sfSimpleBlogPostPeer::PUBLISHED_AT);

	}

	const COUNT = 'COUNT(sf_blog_post.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sf_blog_post.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfSimpleBlogPostPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfSimpleBlogPostPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = sfSimpleBlogPostPeer::doSelectRS($criteria, $con);
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
		$objects = sfSimpleBlogPostPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return sfSimpleBlogPostPeer::populateObjects(sfSimpleBlogPostPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfSimpleBlogPostPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BasesfSimpleBlogPostPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			sfSimpleBlogPostPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = sfSimpleBlogPostPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinOppUser(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfSimpleBlogPostPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfSimpleBlogPostPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfSimpleBlogPostPeer::AUTHOR_ID, OppUserPeer::ID);

		$rs = sfSimpleBlogPostPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinOppUser(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfSimpleBlogPostPeer::addSelectColumns($c);
		$startcol = (sfSimpleBlogPostPeer::NUM_COLUMNS - sfSimpleBlogPostPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppUserPeer::addSelectColumns($c);

		$c->addJoin(sfSimpleBlogPostPeer::AUTHOR_ID, OppUserPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfSimpleBlogPostPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppUserPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getOppUser(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addsfSimpleBlogPost($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initsfSimpleBlogPosts();
				$obj2->addsfSimpleBlogPost($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfSimpleBlogPostPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfSimpleBlogPostPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfSimpleBlogPostPeer::AUTHOR_ID, OppUserPeer::ID);

		$rs = sfSimpleBlogPostPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAll(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfSimpleBlogPostPeer::addSelectColumns($c);
		$startcol2 = (sfSimpleBlogPostPeer::NUM_COLUMNS - sfSimpleBlogPostPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppUserPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppUserPeer::NUM_COLUMNS;

		$c->addJoin(sfSimpleBlogPostPeer::AUTHOR_ID, OppUserPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfSimpleBlogPostPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = OppUserPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppUser(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addsfSimpleBlogPost($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initsfSimpleBlogPosts();
				$obj2->addsfSimpleBlogPost($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}

	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return sfSimpleBlogPostPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfSimpleBlogPostPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfSimpleBlogPostPeer', $values, $con);
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

		$criteria->remove(sfSimpleBlogPostPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BasesfSimpleBlogPostPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasesfSimpleBlogPostPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfSimpleBlogPostPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfSimpleBlogPostPeer', $values, $con);
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
			$comparison = $criteria->getComparison(sfSimpleBlogPostPeer::ID);
			$selectCriteria->add(sfSimpleBlogPostPeer::ID, $criteria->remove(sfSimpleBlogPostPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasesfSimpleBlogPostPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasesfSimpleBlogPostPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(sfSimpleBlogPostPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(sfSimpleBlogPostPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof sfSimpleBlogPost) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(sfSimpleBlogPostPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(sfSimpleBlogPost $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(sfSimpleBlogPostPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(sfSimpleBlogPostPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(sfSimpleBlogPostPeer::DATABASE_NAME, sfSimpleBlogPostPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = sfSimpleBlogPostPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(sfSimpleBlogPostPeer::DATABASE_NAME);

		$criteria->add(sfSimpleBlogPostPeer::ID, $pk);


		$v = sfSimpleBlogPostPeer::doSelect($criteria, $con);

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
			$criteria->add(sfSimpleBlogPostPeer::ID, $pks, Criteria::IN);
			$objs = sfSimpleBlogPostPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BasesfSimpleBlogPostPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'plugins/sfSimpleBlogPlugin/lib/model/map/sfSimpleBlogPostMapBuilder.php';
	Propel::registerMapBuilder('plugins.sfSimpleBlogPlugin.lib.model.map.sfSimpleBlogPostMapBuilder');
}
