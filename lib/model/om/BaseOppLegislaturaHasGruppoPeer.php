<?php


abstract class BaseOppLegislaturaHasGruppoPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'opp_legislatura_has_gruppo';

	
	const CLASS_DEFAULT = 'lib.model.OppLegislaturaHasGruppo';

	
	const NUM_COLUMNS = 3;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const LEGISLATURA = 'opp_legislatura_has_gruppo.LEGISLATURA';

	
	const RAMO = 'opp_legislatura_has_gruppo.RAMO';

	
	const GRUPPO_ID = 'opp_legislatura_has_gruppo.GRUPPO_ID';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Legislatura', 'Ramo', 'GruppoId', ),
		BasePeer::TYPE_COLNAME => array (OppLegislaturaHasGruppoPeer::LEGISLATURA, OppLegislaturaHasGruppoPeer::RAMO, OppLegislaturaHasGruppoPeer::GRUPPO_ID, ),
		BasePeer::TYPE_FIELDNAME => array ('legislatura', 'ramo', 'gruppo_id', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Legislatura' => 0, 'Ramo' => 1, 'GruppoId' => 2, ),
		BasePeer::TYPE_COLNAME => array (OppLegislaturaHasGruppoPeer::LEGISLATURA => 0, OppLegislaturaHasGruppoPeer::RAMO => 1, OppLegislaturaHasGruppoPeer::GRUPPO_ID => 2, ),
		BasePeer::TYPE_FIELDNAME => array ('legislatura' => 0, 'ramo' => 1, 'gruppo_id' => 2, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/OppLegislaturaHasGruppoMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.OppLegislaturaHasGruppoMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = OppLegislaturaHasGruppoPeer::getTableMap();
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
		return str_replace(OppLegislaturaHasGruppoPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(OppLegislaturaHasGruppoPeer::LEGISLATURA);

		$criteria->addSelectColumn(OppLegislaturaHasGruppoPeer::RAMO);

		$criteria->addSelectColumn(OppLegislaturaHasGruppoPeer::GRUPPO_ID);

	}

	const COUNT = 'COUNT(opp_legislatura_has_gruppo.LEGISLATURA)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT opp_legislatura_has_gruppo.LEGISLATURA)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppLegislaturaHasGruppoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppLegislaturaHasGruppoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OppLegislaturaHasGruppoPeer::doSelectRS($criteria, $con);
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
		$objects = OppLegislaturaHasGruppoPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return OppLegislaturaHasGruppoPeer::populateObjects(OppLegislaturaHasGruppoPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			OppLegislaturaHasGruppoPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = OppLegislaturaHasGruppoPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinOppGruppo(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppLegislaturaHasGruppoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppLegislaturaHasGruppoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppLegislaturaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID);

		$rs = OppLegislaturaHasGruppoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinOppGruppo(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppLegislaturaHasGruppoPeer::addSelectColumns($c);
		$startcol = (OppLegislaturaHasGruppoPeer::NUM_COLUMNS - OppLegislaturaHasGruppoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppGruppoPeer::addSelectColumns($c);

		$c->addJoin(OppLegislaturaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppLegislaturaHasGruppoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppGruppoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getOppGruppo(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addOppLegislaturaHasGruppo($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppLegislaturaHasGruppos();
				$obj2->addOppLegislaturaHasGruppo($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppLegislaturaHasGruppoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppLegislaturaHasGruppoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppLegislaturaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID);

		$rs = OppLegislaturaHasGruppoPeer::doSelectRS($criteria, $con);
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

		OppLegislaturaHasGruppoPeer::addSelectColumns($c);
		$startcol2 = (OppLegislaturaHasGruppoPeer::NUM_COLUMNS - OppLegislaturaHasGruppoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppGruppoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppGruppoPeer::NUM_COLUMNS;

		$c->addJoin(OppLegislaturaHasGruppoPeer::GRUPPO_ID, OppGruppoPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppLegislaturaHasGruppoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = OppGruppoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppGruppo(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppLegislaturaHasGruppo($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initOppLegislaturaHasGruppos();
				$obj2->addOppLegislaturaHasGruppo($obj1);
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
		return OppLegislaturaHasGruppoPeer::CLASS_DEFAULT;
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
			$comparison = $criteria->getComparison(OppLegislaturaHasGruppoPeer::LEGISLATURA);
			$selectCriteria->add(OppLegislaturaHasGruppoPeer::LEGISLATURA, $criteria->remove(OppLegislaturaHasGruppoPeer::LEGISLATURA), $comparison);

			$comparison = $criteria->getComparison(OppLegislaturaHasGruppoPeer::RAMO);
			$selectCriteria->add(OppLegislaturaHasGruppoPeer::RAMO, $criteria->remove(OppLegislaturaHasGruppoPeer::RAMO), $comparison);

			$comparison = $criteria->getComparison(OppLegislaturaHasGruppoPeer::GRUPPO_ID);
			$selectCriteria->add(OppLegislaturaHasGruppoPeer::GRUPPO_ID, $criteria->remove(OppLegislaturaHasGruppoPeer::GRUPPO_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(OppLegislaturaHasGruppoPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(OppLegislaturaHasGruppoPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof OppLegislaturaHasGruppo) {

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

			$criteria->add(OppLegislaturaHasGruppoPeer::LEGISLATURA, $vals[0], Criteria::IN);
			$criteria->add(OppLegislaturaHasGruppoPeer::RAMO, $vals[1], Criteria::IN);
			$criteria->add(OppLegislaturaHasGruppoPeer::GRUPPO_ID, $vals[2], Criteria::IN);
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

	
	public static function doValidate(OppLegislaturaHasGruppo $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OppLegislaturaHasGruppoPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OppLegislaturaHasGruppoPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OppLegislaturaHasGruppoPeer::DATABASE_NAME, OppLegislaturaHasGruppoPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OppLegislaturaHasGruppoPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK( $legislatura, $ramo, $gruppo_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(OppLegislaturaHasGruppoPeer::LEGISLATURA, $legislatura);
		$criteria->add(OppLegislaturaHasGruppoPeer::RAMO, $ramo);
		$criteria->add(OppLegislaturaHasGruppoPeer::GRUPPO_ID, $gruppo_id);
		$v = OppLegislaturaHasGruppoPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BaseOppLegislaturaHasGruppoPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/OppLegislaturaHasGruppoMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.OppLegislaturaHasGruppoMapBuilder');
}
