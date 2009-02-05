<?php


abstract class BasesfSimpleBlogCommentPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sf_blog_comment';

	
	const CLASS_DEFAULT = 'plugins.sfSimpleBlogPlugin.lib.model.sfSimpleBlogComment';

	
	const NUM_COLUMNS = 8;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'sf_blog_comment.ID';

	
	const SF_BLOG_POST_ID = 'sf_blog_comment.SF_BLOG_POST_ID';

	
	const AUTHOR_NAME = 'sf_blog_comment.AUTHOR_NAME';

	
	const AUTHOR_EMAIL = 'sf_blog_comment.AUTHOR_EMAIL';

	
	const AUTHOR_URL = 'sf_blog_comment.AUTHOR_URL';

	
	const CONTENT = 'sf_blog_comment.CONTENT';

	
	const IS_MODERATED = 'sf_blog_comment.IS_MODERATED';

	
	const CREATED_AT = 'sf_blog_comment.CREATED_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'SfBlogPostId', 'AuthorName', 'AuthorEmail', 'AuthorUrl', 'Content', 'IsModerated', 'CreatedAt', ),
		BasePeer::TYPE_COLNAME => array (sfSimpleBlogCommentPeer::ID, sfSimpleBlogCommentPeer::SF_BLOG_POST_ID, sfSimpleBlogCommentPeer::AUTHOR_NAME, sfSimpleBlogCommentPeer::AUTHOR_EMAIL, sfSimpleBlogCommentPeer::AUTHOR_URL, sfSimpleBlogCommentPeer::CONTENT, sfSimpleBlogCommentPeer::IS_MODERATED, sfSimpleBlogCommentPeer::CREATED_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'sf_blog_post_id', 'author_name', 'author_email', 'author_url', 'content', 'is_moderated', 'created_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'SfBlogPostId' => 1, 'AuthorName' => 2, 'AuthorEmail' => 3, 'AuthorUrl' => 4, 'Content' => 5, 'IsModerated' => 6, 'CreatedAt' => 7, ),
		BasePeer::TYPE_COLNAME => array (sfSimpleBlogCommentPeer::ID => 0, sfSimpleBlogCommentPeer::SF_BLOG_POST_ID => 1, sfSimpleBlogCommentPeer::AUTHOR_NAME => 2, sfSimpleBlogCommentPeer::AUTHOR_EMAIL => 3, sfSimpleBlogCommentPeer::AUTHOR_URL => 4, sfSimpleBlogCommentPeer::CONTENT => 5, sfSimpleBlogCommentPeer::IS_MODERATED => 6, sfSimpleBlogCommentPeer::CREATED_AT => 7, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'sf_blog_post_id' => 1, 'author_name' => 2, 'author_email' => 3, 'author_url' => 4, 'content' => 5, 'is_moderated' => 6, 'created_at' => 7, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'plugins/sfSimpleBlogPlugin/lib/model/map/sfSimpleBlogCommentMapBuilder.php';
		return BasePeer::getMapBuilder('plugins.sfSimpleBlogPlugin.lib.model.map.sfSimpleBlogCommentMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = sfSimpleBlogCommentPeer::getTableMap();
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
		return str_replace(sfSimpleBlogCommentPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(sfSimpleBlogCommentPeer::ID);

		$criteria->addSelectColumn(sfSimpleBlogCommentPeer::SF_BLOG_POST_ID);

		$criteria->addSelectColumn(sfSimpleBlogCommentPeer::AUTHOR_NAME);

		$criteria->addSelectColumn(sfSimpleBlogCommentPeer::AUTHOR_EMAIL);

		$criteria->addSelectColumn(sfSimpleBlogCommentPeer::AUTHOR_URL);

		$criteria->addSelectColumn(sfSimpleBlogCommentPeer::CONTENT);

		$criteria->addSelectColumn(sfSimpleBlogCommentPeer::IS_MODERATED);

		$criteria->addSelectColumn(sfSimpleBlogCommentPeer::CREATED_AT);

	}

	const COUNT = 'COUNT(sf_blog_comment.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sf_blog_comment.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfSimpleBlogCommentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfSimpleBlogCommentPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = sfSimpleBlogCommentPeer::doSelectRS($criteria, $con);
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
		$objects = sfSimpleBlogCommentPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return sfSimpleBlogCommentPeer::populateObjects(sfSimpleBlogCommentPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfSimpleBlogCommentPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BasesfSimpleBlogCommentPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			sfSimpleBlogCommentPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = sfSimpleBlogCommentPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinsfSimpleBlogPost(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfSimpleBlogCommentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfSimpleBlogCommentPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfSimpleBlogCommentPeer::SF_BLOG_POST_ID, sfSimpleBlogPostPeer::ID);

		$rs = sfSimpleBlogCommentPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinsfSimpleBlogPost(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		sfSimpleBlogCommentPeer::addSelectColumns($c);
		$startcol = (sfSimpleBlogCommentPeer::NUM_COLUMNS - sfSimpleBlogCommentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		sfSimpleBlogPostPeer::addSelectColumns($c);

		$c->addJoin(sfSimpleBlogCommentPeer::SF_BLOG_POST_ID, sfSimpleBlogPostPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfSimpleBlogCommentPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = sfSimpleBlogPostPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getsfSimpleBlogPost(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addsfSimpleBlogComment($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initsfSimpleBlogComments();
				$obj2->addsfSimpleBlogComment($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(sfSimpleBlogCommentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(sfSimpleBlogCommentPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(sfSimpleBlogCommentPeer::SF_BLOG_POST_ID, sfSimpleBlogPostPeer::ID);

		$rs = sfSimpleBlogCommentPeer::doSelectRS($criteria, $con);
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

		sfSimpleBlogCommentPeer::addSelectColumns($c);
		$startcol2 = (sfSimpleBlogCommentPeer::NUM_COLUMNS - sfSimpleBlogCommentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		sfSimpleBlogPostPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + sfSimpleBlogPostPeer::NUM_COLUMNS;

		$c->addJoin(sfSimpleBlogCommentPeer::SF_BLOG_POST_ID, sfSimpleBlogPostPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = sfSimpleBlogCommentPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = sfSimpleBlogPostPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getsfSimpleBlogPost(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addsfSimpleBlogComment($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initsfSimpleBlogComments();
				$obj2->addsfSimpleBlogComment($obj1);
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
		return sfSimpleBlogCommentPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfSimpleBlogCommentPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfSimpleBlogCommentPeer', $values, $con);
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

		$criteria->remove(sfSimpleBlogCommentPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BasesfSimpleBlogCommentPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasesfSimpleBlogCommentPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasesfSimpleBlogCommentPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasesfSimpleBlogCommentPeer', $values, $con);
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
			$comparison = $criteria->getComparison(sfSimpleBlogCommentPeer::ID);
			$selectCriteria->add(sfSimpleBlogCommentPeer::ID, $criteria->remove(sfSimpleBlogCommentPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasesfSimpleBlogCommentPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasesfSimpleBlogCommentPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(sfSimpleBlogCommentPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(sfSimpleBlogCommentPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof sfSimpleBlogComment) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(sfSimpleBlogCommentPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(sfSimpleBlogComment $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(sfSimpleBlogCommentPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(sfSimpleBlogCommentPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(sfSimpleBlogCommentPeer::DATABASE_NAME, sfSimpleBlogCommentPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = sfSimpleBlogCommentPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(sfSimpleBlogCommentPeer::DATABASE_NAME);

		$criteria->add(sfSimpleBlogCommentPeer::ID, $pk);


		$v = sfSimpleBlogCommentPeer::doSelect($criteria, $con);

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
			$criteria->add(sfSimpleBlogCommentPeer::ID, $pks, Criteria::IN);
			$objs = sfSimpleBlogCommentPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BasesfSimpleBlogCommentPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'plugins/sfSimpleBlogPlugin/lib/model/map/sfSimpleBlogCommentMapBuilder.php';
	Propel::registerMapBuilder('plugins.sfSimpleBlogPlugin.lib.model.map.sfSimpleBlogCommentMapBuilder');
}
