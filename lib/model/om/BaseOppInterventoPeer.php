<?php


abstract class BaseOppInterventoPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'opp_intervento';

	
	const CLASS_DEFAULT = 'lib.model.OppIntervento';

	
	const NUM_COLUMNS = 9;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'opp_intervento.ID';

	
	const ATTO_ID = 'opp_intervento.ATTO_ID';

	
	const CARICA_ID = 'opp_intervento.CARICA_ID';

	
	const SEDE_ID = 'opp_intervento.SEDE_ID';

	
	const TIPOLOGIA = 'opp_intervento.TIPOLOGIA';

	
	const URL = 'opp_intervento.URL';

	
	const DATA = 'opp_intervento.DATA';

	
	const NUMERO = 'opp_intervento.NUMERO';

	
	const AP = 'opp_intervento.AP';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'AttoId', 'CaricaId', 'SedeId', 'Tipologia', 'Url', 'Data', 'Numero', 'Ap', ),
		BasePeer::TYPE_COLNAME => array (OppInterventoPeer::ID, OppInterventoPeer::ATTO_ID, OppInterventoPeer::CARICA_ID, OppInterventoPeer::SEDE_ID, OppInterventoPeer::TIPOLOGIA, OppInterventoPeer::URL, OppInterventoPeer::DATA, OppInterventoPeer::NUMERO, OppInterventoPeer::AP, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'atto_id', 'carica_id', 'sede_id', 'tipologia', 'url', 'data', 'numero', 'ap', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'AttoId' => 1, 'CaricaId' => 2, 'SedeId' => 3, 'Tipologia' => 4, 'Url' => 5, 'Data' => 6, 'Numero' => 7, 'Ap' => 8, ),
		BasePeer::TYPE_COLNAME => array (OppInterventoPeer::ID => 0, OppInterventoPeer::ATTO_ID => 1, OppInterventoPeer::CARICA_ID => 2, OppInterventoPeer::SEDE_ID => 3, OppInterventoPeer::TIPOLOGIA => 4, OppInterventoPeer::URL => 5, OppInterventoPeer::DATA => 6, OppInterventoPeer::NUMERO => 7, OppInterventoPeer::AP => 8, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'atto_id' => 1, 'carica_id' => 2, 'sede_id' => 3, 'tipologia' => 4, 'url' => 5, 'data' => 6, 'numero' => 7, 'ap' => 8, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/OppInterventoMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.OppInterventoMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = OppInterventoPeer::getTableMap();
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
		return str_replace(OppInterventoPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(OppInterventoPeer::ID);

		$criteria->addSelectColumn(OppInterventoPeer::ATTO_ID);

		$criteria->addSelectColumn(OppInterventoPeer::CARICA_ID);

		$criteria->addSelectColumn(OppInterventoPeer::SEDE_ID);

		$criteria->addSelectColumn(OppInterventoPeer::TIPOLOGIA);

		$criteria->addSelectColumn(OppInterventoPeer::URL);

		$criteria->addSelectColumn(OppInterventoPeer::DATA);

		$criteria->addSelectColumn(OppInterventoPeer::NUMERO);

		$criteria->addSelectColumn(OppInterventoPeer::AP);

	}

	const COUNT = 'COUNT(opp_intervento.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT opp_intervento.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppInterventoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppInterventoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OppInterventoPeer::doSelectRS($criteria, $con);
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
		$objects = OppInterventoPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return OppInterventoPeer::populateObjects(OppInterventoPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			OppInterventoPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = OppInterventoPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinOppAtto(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppInterventoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppInterventoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppInterventoPeer::ATTO_ID, OppAttoPeer::ID);

		$rs = OppInterventoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinOppCarica(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppInterventoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppInterventoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppInterventoPeer::CARICA_ID, OppCaricaPeer::ID);

		$rs = OppInterventoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinOppSede(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppInterventoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppInterventoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppInterventoPeer::SEDE_ID, OppSedePeer::ID);

		$rs = OppInterventoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinOppAtto(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppInterventoPeer::addSelectColumns($c);
		$startcol = (OppInterventoPeer::NUM_COLUMNS - OppInterventoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppAttoPeer::addSelectColumns($c);

		$c->addJoin(OppInterventoPeer::ATTO_ID, OppAttoPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppInterventoPeer::getOMClass();

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
										$temp_obj2->addOppIntervento($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppInterventos();
				$obj2->addOppIntervento($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinOppCarica(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppInterventoPeer::addSelectColumns($c);
		$startcol = (OppInterventoPeer::NUM_COLUMNS - OppInterventoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppCaricaPeer::addSelectColumns($c);

		$c->addJoin(OppInterventoPeer::CARICA_ID, OppCaricaPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppInterventoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppCaricaPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getOppCarica(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addOppIntervento($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppInterventos();
				$obj2->addOppIntervento($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinOppSede(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppInterventoPeer::addSelectColumns($c);
		$startcol = (OppInterventoPeer::NUM_COLUMNS - OppInterventoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppSedePeer::addSelectColumns($c);

		$c->addJoin(OppInterventoPeer::SEDE_ID, OppSedePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppInterventoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppSedePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getOppSede(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addOppIntervento($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppInterventos();
				$obj2->addOppIntervento($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppInterventoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppInterventoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppInterventoPeer::ATTO_ID, OppAttoPeer::ID);

		$criteria->addJoin(OppInterventoPeer::CARICA_ID, OppCaricaPeer::ID);

		$criteria->addJoin(OppInterventoPeer::SEDE_ID, OppSedePeer::ID);

		$rs = OppInterventoPeer::doSelectRS($criteria, $con);
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

		OppInterventoPeer::addSelectColumns($c);
		$startcol2 = (OppInterventoPeer::NUM_COLUMNS - OppInterventoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppAttoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppAttoPeer::NUM_COLUMNS;

		OppCaricaPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + OppCaricaPeer::NUM_COLUMNS;

		OppSedePeer::addSelectColumns($c);
		$startcol5 = $startcol4 + OppSedePeer::NUM_COLUMNS;

		$c->addJoin(OppInterventoPeer::ATTO_ID, OppAttoPeer::ID);

		$c->addJoin(OppInterventoPeer::CARICA_ID, OppCaricaPeer::ID);

		$c->addJoin(OppInterventoPeer::SEDE_ID, OppSedePeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppInterventoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = OppAttoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppAtto(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppIntervento($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initOppInterventos();
				$obj2->addOppIntervento($obj1);
			}


					
			$omClass = OppCaricaPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getOppCarica(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOppIntervento($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initOppInterventos();
				$obj3->addOppIntervento($obj1);
			}


					
			$omClass = OppSedePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj4 = new $cls();
			$obj4->hydrate($rs, $startcol4);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj4 = $temp_obj1->getOppSede(); 				if ($temp_obj4->getPrimaryKey() === $obj4->getPrimaryKey()) {
					$newObject = false;
					$temp_obj4->addOppIntervento($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj4->initOppInterventos();
				$obj4->addOppIntervento($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptOppAtto(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppInterventoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppInterventoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppInterventoPeer::CARICA_ID, OppCaricaPeer::ID);

		$criteria->addJoin(OppInterventoPeer::SEDE_ID, OppSedePeer::ID);

		$rs = OppInterventoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptOppCarica(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppInterventoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppInterventoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppInterventoPeer::ATTO_ID, OppAttoPeer::ID);

		$criteria->addJoin(OppInterventoPeer::SEDE_ID, OppSedePeer::ID);

		$rs = OppInterventoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptOppSede(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppInterventoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppInterventoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppInterventoPeer::ATTO_ID, OppAttoPeer::ID);

		$criteria->addJoin(OppInterventoPeer::CARICA_ID, OppCaricaPeer::ID);

		$rs = OppInterventoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptOppAtto(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppInterventoPeer::addSelectColumns($c);
		$startcol2 = (OppInterventoPeer::NUM_COLUMNS - OppInterventoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppCaricaPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppCaricaPeer::NUM_COLUMNS;

		OppSedePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + OppSedePeer::NUM_COLUMNS;

		$c->addJoin(OppInterventoPeer::CARICA_ID, OppCaricaPeer::ID);

		$c->addJoin(OppInterventoPeer::SEDE_ID, OppSedePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppInterventoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppCaricaPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppCarica(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppIntervento($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOppInterventos();
				$obj2->addOppIntervento($obj1);
			}

			$omClass = OppSedePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getOppSede(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOppIntervento($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initOppInterventos();
				$obj3->addOppIntervento($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptOppCarica(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppInterventoPeer::addSelectColumns($c);
		$startcol2 = (OppInterventoPeer::NUM_COLUMNS - OppInterventoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppAttoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppAttoPeer::NUM_COLUMNS;

		OppSedePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + OppSedePeer::NUM_COLUMNS;

		$c->addJoin(OppInterventoPeer::ATTO_ID, OppAttoPeer::ID);

		$c->addJoin(OppInterventoPeer::SEDE_ID, OppSedePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppInterventoPeer::getOMClass();

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
					$temp_obj2->addOppIntervento($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOppInterventos();
				$obj2->addOppIntervento($obj1);
			}

			$omClass = OppSedePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getOppSede(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOppIntervento($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initOppInterventos();
				$obj3->addOppIntervento($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptOppSede(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppInterventoPeer::addSelectColumns($c);
		$startcol2 = (OppInterventoPeer::NUM_COLUMNS - OppInterventoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppAttoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppAttoPeer::NUM_COLUMNS;

		OppCaricaPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + OppCaricaPeer::NUM_COLUMNS;

		$c->addJoin(OppInterventoPeer::ATTO_ID, OppAttoPeer::ID);

		$c->addJoin(OppInterventoPeer::CARICA_ID, OppCaricaPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppInterventoPeer::getOMClass();

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
					$temp_obj2->addOppIntervento($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOppInterventos();
				$obj2->addOppIntervento($obj1);
			}

			$omClass = OppCaricaPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3  = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getOppCarica(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOppIntervento($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj3->initOppInterventos();
				$obj3->addOppIntervento($obj1);
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
		return OppInterventoPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(OppInterventoPeer::ID); 

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
			$comparison = $criteria->getComparison(OppInterventoPeer::ID);
			$selectCriteria->add(OppInterventoPeer::ID, $criteria->remove(OppInterventoPeer::ID), $comparison);

			$comparison = $criteria->getComparison(OppInterventoPeer::ATTO_ID);
			$selectCriteria->add(OppInterventoPeer::ATTO_ID, $criteria->remove(OppInterventoPeer::ATTO_ID), $comparison);

			$comparison = $criteria->getComparison(OppInterventoPeer::CARICA_ID);
			$selectCriteria->add(OppInterventoPeer::CARICA_ID, $criteria->remove(OppInterventoPeer::CARICA_ID), $comparison);

			$comparison = $criteria->getComparison(OppInterventoPeer::SEDE_ID);
			$selectCriteria->add(OppInterventoPeer::SEDE_ID, $criteria->remove(OppInterventoPeer::SEDE_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(OppInterventoPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(OppInterventoPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof OppIntervento) {

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
				$vals[3][] = $value[3];
			}

			$criteria->add(OppInterventoPeer::ID, $vals[0], Criteria::IN);
			$criteria->add(OppInterventoPeer::ATTO_ID, $vals[1], Criteria::IN);
			$criteria->add(OppInterventoPeer::CARICA_ID, $vals[2], Criteria::IN);
			$criteria->add(OppInterventoPeer::SEDE_ID, $vals[3], Criteria::IN);
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

	
	public static function doValidate(OppIntervento $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OppInterventoPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OppInterventoPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OppInterventoPeer::DATABASE_NAME, OppInterventoPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OppInterventoPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK( $id, $atto_id, $carica_id, $sede_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(OppInterventoPeer::ID, $id);
		$criteria->add(OppInterventoPeer::ATTO_ID, $atto_id);
		$criteria->add(OppInterventoPeer::CARICA_ID, $carica_id);
		$criteria->add(OppInterventoPeer::SEDE_ID, $sede_id);
		$v = OppInterventoPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BaseOppInterventoPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/OppInterventoMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.OppInterventoMapBuilder');
}
