<?php


abstract class BasenahoWikiRevisionPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'naho_wiki_revision';

	
	const CLASS_DEFAULT = 'plugins.nahoWikiPlugin.lib.model.nahoWikiRevision';

	
	const NUM_COLUMNS = 6;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const CREATED_AT = 'naho_wiki_revision.CREATED_AT';

	
	const PAGE_ID = 'naho_wiki_revision.PAGE_ID';

	
	const REVISION = 'naho_wiki_revision.REVISION';

	
	const USER_NAME = 'naho_wiki_revision.USER_NAME';

	
	const COMMENT = 'naho_wiki_revision.COMMENT';

	
	const CONTENT_ID = 'naho_wiki_revision.CONTENT_ID';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt', 'PageId', 'Revision', 'UserName', 'Comment', 'ContentId', ),
		BasePeer::TYPE_COLNAME => array (nahoWikiRevisionPeer::CREATED_AT, nahoWikiRevisionPeer::PAGE_ID, nahoWikiRevisionPeer::REVISION, nahoWikiRevisionPeer::USER_NAME, nahoWikiRevisionPeer::COMMENT, nahoWikiRevisionPeer::CONTENT_ID, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at', 'page_id', 'revision', 'user_name', 'comment', 'content_id', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('CreatedAt' => 0, 'PageId' => 1, 'Revision' => 2, 'UserName' => 3, 'Comment' => 4, 'ContentId' => 5, ),
		BasePeer::TYPE_COLNAME => array (nahoWikiRevisionPeer::CREATED_AT => 0, nahoWikiRevisionPeer::PAGE_ID => 1, nahoWikiRevisionPeer::REVISION => 2, nahoWikiRevisionPeer::USER_NAME => 3, nahoWikiRevisionPeer::COMMENT => 4, nahoWikiRevisionPeer::CONTENT_ID => 5, ),
		BasePeer::TYPE_FIELDNAME => array ('created_at' => 0, 'page_id' => 1, 'revision' => 2, 'user_name' => 3, 'comment' => 4, 'content_id' => 5, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'plugins/nahoWikiPlugin/lib/model/map/nahoWikiRevisionMapBuilder.php';
		return BasePeer::getMapBuilder('plugins.nahoWikiPlugin.lib.model.map.nahoWikiRevisionMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = nahoWikiRevisionPeer::getTableMap();
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
		return str_replace(nahoWikiRevisionPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(nahoWikiRevisionPeer::CREATED_AT);

		$criteria->addSelectColumn(nahoWikiRevisionPeer::PAGE_ID);

		$criteria->addSelectColumn(nahoWikiRevisionPeer::REVISION);

		$criteria->addSelectColumn(nahoWikiRevisionPeer::USER_NAME);

		$criteria->addSelectColumn(nahoWikiRevisionPeer::COMMENT);

		$criteria->addSelectColumn(nahoWikiRevisionPeer::CONTENT_ID);

	}

	const COUNT = 'COUNT(naho_wiki_revision.PAGE_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT naho_wiki_revision.PAGE_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(nahoWikiRevisionPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(nahoWikiRevisionPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = nahoWikiRevisionPeer::doSelectRS($criteria, $con);
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
		$objects = nahoWikiRevisionPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return nahoWikiRevisionPeer::populateObjects(nahoWikiRevisionPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BasenahoWikiRevisionPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BasenahoWikiRevisionPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			nahoWikiRevisionPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = nahoWikiRevisionPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinnahoWikiPage(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(nahoWikiRevisionPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(nahoWikiRevisionPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(nahoWikiRevisionPeer::PAGE_ID, nahoWikiPagePeer::ID);

		$rs = nahoWikiRevisionPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinnahoWikiContent(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(nahoWikiRevisionPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(nahoWikiRevisionPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(nahoWikiRevisionPeer::CONTENT_ID, nahoWikiContentPeer::ID);

		$rs = nahoWikiRevisionPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinnahoWikiPage(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		nahoWikiRevisionPeer::addSelectColumns($c);
		$startcol = (nahoWikiRevisionPeer::NUM_COLUMNS - nahoWikiRevisionPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		nahoWikiPagePeer::addSelectColumns($c);

		$c->addJoin(nahoWikiRevisionPeer::PAGE_ID, nahoWikiPagePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = nahoWikiRevisionPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = nahoWikiPagePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getnahoWikiPage(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addnahoWikiRevision($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initnahoWikiRevisions();
				$obj2->addnahoWikiRevision($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinnahoWikiContent(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		nahoWikiRevisionPeer::addSelectColumns($c);
		$startcol = (nahoWikiRevisionPeer::NUM_COLUMNS - nahoWikiRevisionPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		nahoWikiContentPeer::addSelectColumns($c);

		$c->addJoin(nahoWikiRevisionPeer::CONTENT_ID, nahoWikiContentPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = nahoWikiRevisionPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = nahoWikiContentPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getnahoWikiContent(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addnahoWikiRevision($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initnahoWikiRevisions();
				$obj2->addnahoWikiRevision($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(nahoWikiRevisionPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(nahoWikiRevisionPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(nahoWikiRevisionPeer::PAGE_ID, nahoWikiPagePeer::ID);

		$criteria->addJoin(nahoWikiRevisionPeer::CONTENT_ID, nahoWikiContentPeer::ID);

		$rs = nahoWikiRevisionPeer::doSelectRS($criteria, $con);
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

		nahoWikiRevisionPeer::addSelectColumns($c);
		$startcol2 = (nahoWikiRevisionPeer::NUM_COLUMNS - nahoWikiRevisionPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		nahoWikiPagePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + nahoWikiPagePeer::NUM_COLUMNS;

		nahoWikiContentPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + nahoWikiContentPeer::NUM_COLUMNS;

		$c->addJoin(nahoWikiRevisionPeer::PAGE_ID, nahoWikiPagePeer::ID);

		$c->addJoin(nahoWikiRevisionPeer::CONTENT_ID, nahoWikiContentPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = nahoWikiRevisionPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = nahoWikiPagePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getnahoWikiPage(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addnahoWikiRevision($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initnahoWikiRevisions();
				$obj2->addnahoWikiRevision($obj1);
			}


					
			$omClass = nahoWikiContentPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getnahoWikiContent(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addnahoWikiRevision($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initnahoWikiRevisions();
				$obj3->addnahoWikiRevision($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptnahoWikiPage(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(nahoWikiRevisionPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(nahoWikiRevisionPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(nahoWikiRevisionPeer::CONTENT_ID, nahoWikiContentPeer::ID);

		$rs = nahoWikiRevisionPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptnahoWikiContent(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(nahoWikiRevisionPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(nahoWikiRevisionPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(nahoWikiRevisionPeer::PAGE_ID, nahoWikiPagePeer::ID);

		$rs = nahoWikiRevisionPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptnahoWikiPage(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		nahoWikiRevisionPeer::addSelectColumns($c);
		$startcol2 = (nahoWikiRevisionPeer::NUM_COLUMNS - nahoWikiRevisionPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		nahoWikiContentPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + nahoWikiContentPeer::NUM_COLUMNS;

		$c->addJoin(nahoWikiRevisionPeer::CONTENT_ID, nahoWikiContentPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = nahoWikiRevisionPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = nahoWikiContentPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getnahoWikiContent(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addnahoWikiRevision($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initnahoWikiRevisions();
				$obj2->addnahoWikiRevision($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptnahoWikiContent(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		nahoWikiRevisionPeer::addSelectColumns($c);
		$startcol2 = (nahoWikiRevisionPeer::NUM_COLUMNS - nahoWikiRevisionPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		nahoWikiPagePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + nahoWikiPagePeer::NUM_COLUMNS;

		$c->addJoin(nahoWikiRevisionPeer::PAGE_ID, nahoWikiPagePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = nahoWikiRevisionPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = nahoWikiPagePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getnahoWikiPage(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addnahoWikiRevision($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initnahoWikiRevisions();
				$obj2->addnahoWikiRevision($obj1);
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
		return nahoWikiRevisionPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasenahoWikiRevisionPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasenahoWikiRevisionPeer', $values, $con);
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


				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BasenahoWikiRevisionPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BasenahoWikiRevisionPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BasenahoWikiRevisionPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BasenahoWikiRevisionPeer', $values, $con);
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
			$comparison = $criteria->getComparison(nahoWikiRevisionPeer::PAGE_ID);
			$selectCriteria->add(nahoWikiRevisionPeer::PAGE_ID, $criteria->remove(nahoWikiRevisionPeer::PAGE_ID), $comparison);

			$comparison = $criteria->getComparison(nahoWikiRevisionPeer::REVISION);
			$selectCriteria->add(nahoWikiRevisionPeer::REVISION, $criteria->remove(nahoWikiRevisionPeer::REVISION), $comparison);

			$comparison = $criteria->getComparison(nahoWikiRevisionPeer::CONTENT_ID);
			$selectCriteria->add(nahoWikiRevisionPeer::CONTENT_ID, $criteria->remove(nahoWikiRevisionPeer::CONTENT_ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BasenahoWikiRevisionPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BasenahoWikiRevisionPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(nahoWikiRevisionPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(nahoWikiRevisionPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof nahoWikiRevision) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
												if(count($values) == count($values, COUNT_RECURSIVE))
			{
								$values = array($values);
			}
			$vals = array();
			foreach($values as $value)
			{

				$vals[0][] = $value[0];
				$vals[1][] = $value[1];
				$vals[2][] = $value[2];
			}

			$criteria->add(nahoWikiRevisionPeer::PAGE_ID, $vals[0], Criteria::IN);
			$criteria->add(nahoWikiRevisionPeer::REVISION, $vals[1], Criteria::IN);
			$criteria->add(nahoWikiRevisionPeer::CONTENT_ID, $vals[2], Criteria::IN);
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

	
	public static function doValidate(nahoWikiRevision $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(nahoWikiRevisionPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(nahoWikiRevisionPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(nahoWikiRevisionPeer::DATABASE_NAME, nahoWikiRevisionPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = nahoWikiRevisionPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK( $page_id, $revision, $content_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(nahoWikiRevisionPeer::PAGE_ID, $page_id);
		$criteria->add(nahoWikiRevisionPeer::REVISION, $revision);
		$criteria->add(nahoWikiRevisionPeer::CONTENT_ID, $content_id);
		$v = nahoWikiRevisionPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BasenahoWikiRevisionPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'plugins/nahoWikiPlugin/lib/model/map/nahoWikiRevisionMapBuilder.php';
	Propel::registerMapBuilder('plugins.nahoWikiPlugin.lib.model.map.nahoWikiRevisionMapBuilder');
}
