<?php


abstract class BaseOppCaricaPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'opp_carica';

	
	const CLASS_DEFAULT = 'lib.model.OppCarica';

	
	const NUM_COLUMNS = 16;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'opp_carica.ID';

	
	const POLITICO_ID = 'opp_carica.POLITICO_ID';

	
	const TIPO_CARICA_ID = 'opp_carica.TIPO_CARICA_ID';

	
	const CARICA = 'opp_carica.CARICA';

	
	const DATA_INIZIO = 'opp_carica.DATA_INIZIO';

	
	const DATA_FINE = 'opp_carica.DATA_FINE';

	
	const LEGISLATURA = 'opp_carica.LEGISLATURA';

	
	const CIRCOSCRIZIONE = 'opp_carica.CIRCOSCRIZIONE';

	
	const PRESENZE = 'opp_carica.PRESENZE';

	
	const ASSENZE = 'opp_carica.ASSENZE';

	
	const MISSIONI = 'opp_carica.MISSIONI';

	
	const PARLIAMENT_ID = 'opp_carica.PARLIAMENT_ID';

	
	const INDICE = 'opp_carica.INDICE';

	
	const SCAGLIONE = 'opp_carica.SCAGLIONE';

	
	const POSIZIONE = 'opp_carica.POSIZIONE';

	
	const MEDIA = 'opp_carica.MEDIA';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'PoliticoId', 'TipoCaricaId', 'Carica', 'DataInizio', 'DataFine', 'Legislatura', 'Circoscrizione', 'Presenze', 'Assenze', 'Missioni', 'ParliamentId', 'Indice', 'Scaglione', 'Posizione', 'Media', ),
		BasePeer::TYPE_COLNAME => array (OppCaricaPeer::ID, OppCaricaPeer::POLITICO_ID, OppCaricaPeer::TIPO_CARICA_ID, OppCaricaPeer::CARICA, OppCaricaPeer::DATA_INIZIO, OppCaricaPeer::DATA_FINE, OppCaricaPeer::LEGISLATURA, OppCaricaPeer::CIRCOSCRIZIONE, OppCaricaPeer::PRESENZE, OppCaricaPeer::ASSENZE, OppCaricaPeer::MISSIONI, OppCaricaPeer::PARLIAMENT_ID, OppCaricaPeer::INDICE, OppCaricaPeer::SCAGLIONE, OppCaricaPeer::POSIZIONE, OppCaricaPeer::MEDIA, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'politico_id', 'tipo_carica_id', 'carica', 'data_inizio', 'data_fine', 'legislatura', 'circoscrizione', 'presenze', 'assenze', 'missioni', 'parliament_id', 'indice', 'scaglione', 'posizione', 'media', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'PoliticoId' => 1, 'TipoCaricaId' => 2, 'Carica' => 3, 'DataInizio' => 4, 'DataFine' => 5, 'Legislatura' => 6, 'Circoscrizione' => 7, 'Presenze' => 8, 'Assenze' => 9, 'Missioni' => 10, 'ParliamentId' => 11, 'Indice' => 12, 'Scaglione' => 13, 'Posizione' => 14, 'Media' => 15, ),
		BasePeer::TYPE_COLNAME => array (OppCaricaPeer::ID => 0, OppCaricaPeer::POLITICO_ID => 1, OppCaricaPeer::TIPO_CARICA_ID => 2, OppCaricaPeer::CARICA => 3, OppCaricaPeer::DATA_INIZIO => 4, OppCaricaPeer::DATA_FINE => 5, OppCaricaPeer::LEGISLATURA => 6, OppCaricaPeer::CIRCOSCRIZIONE => 7, OppCaricaPeer::PRESENZE => 8, OppCaricaPeer::ASSENZE => 9, OppCaricaPeer::MISSIONI => 10, OppCaricaPeer::PARLIAMENT_ID => 11, OppCaricaPeer::INDICE => 12, OppCaricaPeer::SCAGLIONE => 13, OppCaricaPeer::POSIZIONE => 14, OppCaricaPeer::MEDIA => 15, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'politico_id' => 1, 'tipo_carica_id' => 2, 'carica' => 3, 'data_inizio' => 4, 'data_fine' => 5, 'legislatura' => 6, 'circoscrizione' => 7, 'presenze' => 8, 'assenze' => 9, 'missioni' => 10, 'parliament_id' => 11, 'indice' => 12, 'scaglione' => 13, 'posizione' => 14, 'media' => 15, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/OppCaricaMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.OppCaricaMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = OppCaricaPeer::getTableMap();
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
		return str_replace(OppCaricaPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(OppCaricaPeer::ID);

		$criteria->addSelectColumn(OppCaricaPeer::POLITICO_ID);

		$criteria->addSelectColumn(OppCaricaPeer::TIPO_CARICA_ID);

		$criteria->addSelectColumn(OppCaricaPeer::CARICA);

		$criteria->addSelectColumn(OppCaricaPeer::DATA_INIZIO);

		$criteria->addSelectColumn(OppCaricaPeer::DATA_FINE);

		$criteria->addSelectColumn(OppCaricaPeer::LEGISLATURA);

		$criteria->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE);

		$criteria->addSelectColumn(OppCaricaPeer::PRESENZE);

		$criteria->addSelectColumn(OppCaricaPeer::ASSENZE);

		$criteria->addSelectColumn(OppCaricaPeer::MISSIONI);

		$criteria->addSelectColumn(OppCaricaPeer::PARLIAMENT_ID);

		$criteria->addSelectColumn(OppCaricaPeer::INDICE);

		$criteria->addSelectColumn(OppCaricaPeer::SCAGLIONE);

		$criteria->addSelectColumn(OppCaricaPeer::POSIZIONE);

		$criteria->addSelectColumn(OppCaricaPeer::MEDIA);

	}

	const COUNT = 'COUNT(opp_carica.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT opp_carica.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = OppCaricaPeer::doSelectRS($criteria, $con);
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
		$objects = OppCaricaPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return OppCaricaPeer::populateObjects(OppCaricaPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			OppCaricaPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = OppCaricaPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinOppPolitico(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);

		$rs = OppCaricaPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinOppTipoCarica(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppCaricaPeer::TIPO_CARICA_ID, OppTipoCaricaPeer::ID);

		$rs = OppCaricaPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinOppPolitico(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppCaricaPeer::addSelectColumns($c);
		$startcol = (OppCaricaPeer::NUM_COLUMNS - OppCaricaPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppPoliticoPeer::addSelectColumns($c);

		$c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppCaricaPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppPoliticoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getOppPolitico(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addOppCarica($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppCaricas();
				$obj2->addOppCarica($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinOppTipoCarica(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppCaricaPeer::addSelectColumns($c);
		$startcol = (OppCaricaPeer::NUM_COLUMNS - OppCaricaPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		OppTipoCaricaPeer::addSelectColumns($c);

		$c->addJoin(OppCaricaPeer::TIPO_CARICA_ID, OppTipoCaricaPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppCaricaPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppTipoCaricaPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getOppTipoCarica(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addOppCarica($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initOppCaricas();
				$obj2->addOppCarica($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);

		$criteria->addJoin(OppCaricaPeer::TIPO_CARICA_ID, OppTipoCaricaPeer::ID);

		$rs = OppCaricaPeer::doSelectRS($criteria, $con);
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

		OppCaricaPeer::addSelectColumns($c);
		$startcol2 = (OppCaricaPeer::NUM_COLUMNS - OppCaricaPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppPoliticoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppPoliticoPeer::NUM_COLUMNS;

		OppTipoCaricaPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + OppTipoCaricaPeer::NUM_COLUMNS;

		$c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);

		$c->addJoin(OppCaricaPeer::TIPO_CARICA_ID, OppTipoCaricaPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppCaricaPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = OppPoliticoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppPolitico(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppCarica($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initOppCaricas();
				$obj2->addOppCarica($obj1);
			}


					
			$omClass = OppTipoCaricaPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getOppTipoCarica(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addOppCarica($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initOppCaricas();
				$obj3->addOppCarica($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptOppPolitico(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppCaricaPeer::TIPO_CARICA_ID, OppTipoCaricaPeer::ID);

		$rs = OppCaricaPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptOppTipoCarica(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(OppCaricaPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);

		$rs = OppCaricaPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptOppPolitico(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppCaricaPeer::addSelectColumns($c);
		$startcol2 = (OppCaricaPeer::NUM_COLUMNS - OppCaricaPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppTipoCaricaPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppTipoCaricaPeer::NUM_COLUMNS;

		$c->addJoin(OppCaricaPeer::TIPO_CARICA_ID, OppTipoCaricaPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppCaricaPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppTipoCaricaPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppTipoCarica(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppCarica($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOppCaricas();
				$obj2->addOppCarica($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptOppTipoCarica(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		OppCaricaPeer::addSelectColumns($c);
		$startcol2 = (OppCaricaPeer::NUM_COLUMNS - OppCaricaPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		OppPoliticoPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + OppPoliticoPeer::NUM_COLUMNS;

		$c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = OppCaricaPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = OppPoliticoPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getOppPolitico(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addOppCarica($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initOppCaricas();
				$obj2->addOppCarica($obj1);
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
		return OppCaricaPeer::CLASS_DEFAULT;
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
			$comparison = $criteria->getComparison(OppCaricaPeer::ID);
			$selectCriteria->add(OppCaricaPeer::ID, $criteria->remove(OppCaricaPeer::ID), $comparison);

			$comparison = $criteria->getComparison(OppCaricaPeer::POLITICO_ID);
			$selectCriteria->add(OppCaricaPeer::POLITICO_ID, $criteria->remove(OppCaricaPeer::POLITICO_ID), $comparison);

			$comparison = $criteria->getComparison(OppCaricaPeer::TIPO_CARICA_ID);
			$selectCriteria->add(OppCaricaPeer::TIPO_CARICA_ID, $criteria->remove(OppCaricaPeer::TIPO_CARICA_ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(OppCaricaPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(OppCaricaPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof OppCarica) {

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

			$criteria->add(OppCaricaPeer::ID, $vals[0], Criteria::IN);
			$criteria->add(OppCaricaPeer::POLITICO_ID, $vals[1], Criteria::IN);
			$criteria->add(OppCaricaPeer::TIPO_CARICA_ID, $vals[2], Criteria::IN);
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

	
	public static function doValidate(OppCarica $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(OppCaricaPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(OppCaricaPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(OppCaricaPeer::DATABASE_NAME, OppCaricaPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = OppCaricaPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK( $id, $politico_id, $tipo_carica_id, $con = null) {
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$criteria = new Criteria();
		$criteria->add(OppCaricaPeer::ID, $id);
		$criteria->add(OppCaricaPeer::POLITICO_ID, $politico_id);
		$criteria->add(OppCaricaPeer::TIPO_CARICA_ID, $tipo_carica_id);
		$v = OppCaricaPeer::doSelect($criteria, $con);

		return !empty($v) ? $v[0] : null;
	}
} 
if (Propel::isInit()) {
			try {
		BaseOppCaricaPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/OppCaricaMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.OppCaricaMapBuilder');
}
