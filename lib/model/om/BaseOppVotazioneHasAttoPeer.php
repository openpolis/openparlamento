<?php


abstract class BaseOppVotazioneHasAttoPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'opp_votazione_has_atto';

	
	const CLASS_DEFAULT = 'lib.model.OppVotazioneHasAtto';

	
	const NUM_COLUMNS = 2;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const VOTAZIONE_ID = 'opp_votazione_has_atto.VOTAZIONE_ID';

	
	const ATTO_ID = 'opp_votazione_has_atto.ATTO_ID';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('VotazioneId', 'AttoId', ),
		BasePeer::TYPE_COLNAME => array (OppVotazioneHasAttoPeer::VOTAZIONE_ID, OppVotazioneHasAttoPeer::ATTO_ID, ),
		BasePeer::TYPE_FIELDNAME => array ('votazione_id', 'atto_id', ),
		BasePeer::TYPE_NUM => array (0, 1, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('VotazioneId' => 0, 'AttoId' => 1, ),
		BasePeer::TYPE_COLNAME => array (OppVotazioneHasAttoPeer::VOTAZIONE_ID => 0, OppVotazioneHasAttoPeer::ATTO_ID => 1, ),
		BasePeer::TYPE_FIELDNAME => array ('votazione_id' => 0, 'atto_id' => 1, ),
		BasePeer::TYPE_NUM => array (0, 1, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/OppVotazioneHasAttoMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.OppVotazioneHasAttoMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = OppVotazioneHasAttoPeer::getTableMap();
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
		return str_replace(OppVotazioneHasAttoPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(OppVotazioneHasAttoPeer::VOTAZIONE_ID);

		$criteria->addSelectColumn(OppVotazioneHasAttoPeer::ATTO_ID);

	}

	const COUNT = 'COUNT(opp_votazione_has_atto.VOTAZIONE_ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT opp_votazione_has_atto.VOTAZIONE_ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppVotazioneHasAttoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppVotazioneHasAttoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OppVotazioneHasAttoPeer::doSelectRS($criteria, $con);
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
		$objects = OppVotazioneHasAttoPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return OppVotazioneHasAttoPeer::populateObjects(OppVotazioneHasAttoPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			OppVotazioneHasAttoPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = OppVotazioneHasAttoPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinOppVotazione(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppVotazioneHasAttoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppVotazioneHasAttoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppVotazioneHasAttoPeer::VOTAZIONE_ID, OppVotazionePeer::ID);

		$rs = OppVotazioneHasAttoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinOppAtto(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppVotazioneHasAttoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppVotazioneHasAttoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppVotazioneHasAttoPeer::ATTO_ID, OppAttoPeer::ID);

		$rs = OppVotazioneHasAttoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinOppVotazione(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppVotazioneHasAttoPeer::addSelectColumns($c);
		$startcol = (OppVotazioneHasAttoPeer::NUM_COLUMNS - OppVotazioneHasAttoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppVotazionePeer::addSelectColumns($c);

		$c->addJoin(OppVotazioneHasAttoPeer::VOTAZIONE_ID, OppVotazionePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppVotazioneHasAttoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppVotazionePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getOppVotazione(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addOppVotazioneHasAtto($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppVotazioneHasAttos();
				$obj2->addOppVotazioneHasAtto($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinOppAtto(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppVotazioneHasAttoPeer::addSelectColumns($c);
		$startcol = (OppVotazioneHasAttoPeer::NUM_COLUMNS - OppVotazioneHasAttoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppAttoPeer::addSelectColumns($c);

		$c->addJoin(OppVotazioneHasAttoPeer::ATTO_ID, OppAttoPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppVotazioneHasAttoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppAttoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getOppAtto(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addOppVotazioneHasAtto($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppVotazioneHasAttos();
				$obj2->addOppVotazioneHasAtto($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppVotazioneHasAttoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppVotazioneHasAttoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppVotazioneHasAttoPeer::VOTAZIONE_ID, OppVotazionePeer::ID);

		$criteria->addJoin(OppVotazioneHasAttoPeer::ATTO_ID, OppAttoPeer::ID);

		$rs = OppVotazioneHasAttoPeer::doSelectRS($criteria, $con);
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

		OppVotazioneHasAttoPeer::addSelectColumns($c);
		$startcol2 = (OppVotazioneHasAttoPeer::NUM_COLUMNS - OppVotazioneHasAttoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppVotazionePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppVotazionePeer::NUM_COLUMNS;

		OppAttoPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + OppAttoPeer::NUM_COLUMNS;

		$c->addJoin(OppVotazioneHasAttoPeer::VOTAZIONE_ID, OppVotazionePeer::ID);

		$c->addJoin(OppVotazioneHasAttoPeer::ATTO_ID, OppAttoPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppVotazioneHasAttoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = OppVotazionePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppVotazione(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppVotazioneHasAtto($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initOppVotazioneHasAttos();
				$obj2->addOppVotazioneHasAtto($obj1);
			}


					
			$omClass = OppAttoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getOppAtto(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOppVotazioneHasAtto($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initOppVotazioneHasAttos();
				$obj3->addOppVotazioneHasAtto($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptOppVotazione(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppVotazioneHasAttoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppVotazioneHasAttoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppVotazioneHasAttoPeer::ATTO_ID, OppAttoPeer::ID);

		$rs = OppVotazioneHasAttoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptOppAtto(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppVotazioneHasAttoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppVotazioneHasAttoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppVotazioneHasAttoPeer::VOTAZIONE_ID, OppVotazionePeer::ID);

		$rs = OppVotazioneHasAttoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptOppVotazione(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppVotazioneHasAttoPeer::addSelectColumns($c);
		$startcol2 = (OppVotazioneHasAttoPeer::NUM_COLUMNS - OppVotazioneHasAttoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppAttoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppAttoPeer::NUM_COLUMNS;

		$c->addJoin(OppVotazioneHasAttoPeer::ATTO_ID, OppAttoPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppVotazioneHasAttoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppAttoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppAtto(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppVotazioneHasAtto($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOppVotazioneHasAttos();
				$obj2->addOppVotazioneHasAtto($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptOppAtto(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppVotazioneHasAttoPeer::addSelectColumns($c);
		$startcol2 = (OppVotazioneHasAttoPeer::NUM_COLUMNS - OppVotazioneHasAttoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppVotazionePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppVotazionePeer::NUM_COLUMNS;

		$c->addJoin(OppVotazioneHasAttoPeer::VOTAZIONE_ID, OppVotazionePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppVotazioneHasAttoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppVotazionePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppVotazione(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppVotazioneHasAtto($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOppVotazioneHasAttos();
				$obj2->addOppVotazioneHasAtto($obj1);
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
		return OppVotazioneHasAttoPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
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

		return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(OppVotazioneHasAttoPeer::VOTAZIONE_ID);
			$selectCriteria->add(OppVotazioneHasAttoPeer::VOTAZIONE_ID, $criteria->remove(OppVotazioneHasAttoPeer::VOTAZIONE_ID), $comparison);

			$comparison = $criteria->getComparison(OppVotazioneHasAttoPeer::ATTO_ID);
			$selectCriteria->add(OppVotazioneHasAttoPeer::ATTO_ID, $criteria->remove(OppVotazioneHasAttoPeer::ATTO_ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 		try {
									$con->begin();
			$affectedRows += BasePeer::doDeleteAll(OppVotazioneHasAttoPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(OppVotazioneHasAttoPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof OppVotazioneHasAtto) {

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
			}

			$criteria->add(OppVotazioneHasAttoPeer::VOTAZIONE_ID, $vals[0], Criteria::IN);
			$criteria->add(OppVotazioneHasAttoPeer::ATTO_ID, $vals[1], Criteria::IN);
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

	
	public static function doValidate(OppVotazioneHasAtto $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OppVotazioneHasAttoPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OppVotazioneHasAttoPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OppVotazioneHasAttoPeer::DATABASE_NAME, OppVotazioneHasAttoPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OppVotazioneHasAttoPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK( $votazione_id, $atto_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(OppVotazioneHasAttoPeer::VOTAZIONE_ID, $votazione_id);
		$criteria->add(OppVotazioneHasAttoPeer::ATTO_ID, $atto_id);
		$v = OppVotazioneHasAttoPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BaseOppVotazioneHasAttoPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/OppVotazioneHasAttoMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.OppVotazioneHasAttoMapBuilder');
}
