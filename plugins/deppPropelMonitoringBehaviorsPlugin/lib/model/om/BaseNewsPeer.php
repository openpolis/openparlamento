<?php


abstract class BaseNewsPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'sf_news_cache';

	
	const CLASS_DEFAULT = 'plugins.deppPropelMonitoringBehaviorsPlugin.lib.model.News';

	
	const NUM_COLUMNS = 14;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'sf_news_cache.ID';

	
	const CREATED_AT = 'sf_news_cache.CREATED_AT';

	
	const GENERATOR_MODEL = 'sf_news_cache.GENERATOR_MODEL';

	
	const GENERATOR_PRIMARY_KEYS = 'sf_news_cache.GENERATOR_PRIMARY_KEYS';

	
	const RELATED_MONITORABLE_MODEL = 'sf_news_cache.RELATED_MONITORABLE_MODEL';

	
	const RELATED_MONITORABLE_ID = 'sf_news_cache.RELATED_MONITORABLE_ID';

	
	const DATE = 'sf_news_cache.DATE';

	
	const PRIORITY = 'sf_news_cache.PRIORITY';

	
	const TIPO_ATTO_ID = 'sf_news_cache.TIPO_ATTO_ID';

	
	const DATA_PRESENTAZIONE_ATTO = 'sf_news_cache.DATA_PRESENTAZIONE_ATTO';

	
	const RAMO_VOTAZIONE = 'sf_news_cache.RAMO_VOTAZIONE';

	
	const SEDE_INTERVENTO_ID = 'sf_news_cache.SEDE_INTERVENTO_ID';

	
	const SUCC = 'sf_news_cache.SUCC';

	
	const TAG_ID = 'sf_news_cache.TAG_ID';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'CreatedAt', 'GeneratorModel', 'GeneratorPrimaryKeys', 'RelatedMonitorableModel', 'RelatedMonitorableId', 'Date', 'Priority', 'TipoAttoId', 'DataPresentazioneAtto', 'RamoVotazione', 'SedeInterventoId', 'Succ', 'TagId', ),
		BasePeer::TYPE_COLNAME => array (NewsPeer::ID, NewsPeer::CREATED_AT, NewsPeer::GENERATOR_MODEL, NewsPeer::GENERATOR_PRIMARY_KEYS, NewsPeer::RELATED_MONITORABLE_MODEL, NewsPeer::RELATED_MONITORABLE_ID, NewsPeer::DATE, NewsPeer::PRIORITY, NewsPeer::TIPO_ATTO_ID, NewsPeer::DATA_PRESENTAZIONE_ATTO, NewsPeer::RAMO_VOTAZIONE, NewsPeer::SEDE_INTERVENTO_ID, NewsPeer::SUCC, NewsPeer::TAG_ID, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'created_at', 'generator_model', 'generator_primary_keys', 'related_monitorable_model', 'related_monitorable_id', 'date', 'priority', 'tipo_atto_id', 'data_presentazione_atto', 'ramo_votazione', 'sede_intervento_id', 'succ', 'tag_id', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'CreatedAt' => 1, 'GeneratorModel' => 2, 'GeneratorPrimaryKeys' => 3, 'RelatedMonitorableModel' => 4, 'RelatedMonitorableId' => 5, 'Date' => 6, 'Priority' => 7, 'TipoAttoId' => 8, 'DataPresentazioneAtto' => 9, 'RamoVotazione' => 10, 'SedeInterventoId' => 11, 'Succ' => 12, 'TagId' => 13, ),
		BasePeer::TYPE_COLNAME => array (NewsPeer::ID => 0, NewsPeer::CREATED_AT => 1, NewsPeer::GENERATOR_MODEL => 2, NewsPeer::GENERATOR_PRIMARY_KEYS => 3, NewsPeer::RELATED_MONITORABLE_MODEL => 4, NewsPeer::RELATED_MONITORABLE_ID => 5, NewsPeer::DATE => 6, NewsPeer::PRIORITY => 7, NewsPeer::TIPO_ATTO_ID => 8, NewsPeer::DATA_PRESENTAZIONE_ATTO => 9, NewsPeer::RAMO_VOTAZIONE => 10, NewsPeer::SEDE_INTERVENTO_ID => 11, NewsPeer::SUCC => 12, NewsPeer::TAG_ID => 13, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'created_at' => 1, 'generator_model' => 2, 'generator_primary_keys' => 3, 'related_monitorable_model' => 4, 'related_monitorable_id' => 5, 'date' => 6, 'priority' => 7, 'tipo_atto_id' => 8, 'data_presentazione_atto' => 9, 'ramo_votazione' => 10, 'sede_intervento_id' => 11, 'succ' => 12, 'tag_id' => 13, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'plugins/deppPropelMonitoringBehaviorsPlugin/lib/model/map/NewsMapBuilder.php';
		return BasePeer::getMapBuilder('plugins.deppPropelMonitoringBehaviorsPlugin.lib.model.map.NewsMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = NewsPeer::getTableMap();
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
		return str_replace(NewsPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(NewsPeer::ID);

		$criteria->addSelectColumn(NewsPeer::CREATED_AT);

		$criteria->addSelectColumn(NewsPeer::GENERATOR_MODEL);

		$criteria->addSelectColumn(NewsPeer::GENERATOR_PRIMARY_KEYS);

		$criteria->addSelectColumn(NewsPeer::RELATED_MONITORABLE_MODEL);

		$criteria->addSelectColumn(NewsPeer::RELATED_MONITORABLE_ID);

		$criteria->addSelectColumn(NewsPeer::DATE);

		$criteria->addSelectColumn(NewsPeer::PRIORITY);

		$criteria->addSelectColumn(NewsPeer::TIPO_ATTO_ID);

		$criteria->addSelectColumn(NewsPeer::DATA_PRESENTAZIONE_ATTO);

		$criteria->addSelectColumn(NewsPeer::RAMO_VOTAZIONE);

		$criteria->addSelectColumn(NewsPeer::SEDE_INTERVENTO_ID);

		$criteria->addSelectColumn(NewsPeer::SUCC);

		$criteria->addSelectColumn(NewsPeer::TAG_ID);

	}

	const COUNT = 'COUNT(sf_news_cache.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT sf_news_cache.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(NewsPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(NewsPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = NewsPeer::doSelectRS($criteria, $con);
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
		$objects = NewsPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return NewsPeer::populateObjects(NewsPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{

    foreach (sfMixer::getCallables('BaseNewsPeer:addDoSelectRS:addDoSelectRS') as $callable)
    {
      call_user_func($callable, 'BaseNewsPeer', $criteria, $con);
    }


		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			NewsPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = NewsPeer::getOMClass();
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
		return NewsPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseNewsPeer:doInsert:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseNewsPeer', $values, $con);
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

		$criteria->remove(NewsPeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		
    foreach (sfMixer::getCallables('BaseNewsPeer:doInsert:post') as $callable)
    {
      call_user_func($callable, 'BaseNewsPeer', $values, $con, $pk);
    }

    return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{

    foreach (sfMixer::getCallables('BaseNewsPeer:doUpdate:pre') as $callable)
    {
      $ret = call_user_func($callable, 'BaseNewsPeer', $values, $con);
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
			$comparison = $criteria->getComparison(NewsPeer::ID);
			$selectCriteria->add(NewsPeer::ID, $criteria->remove(NewsPeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		$ret = BasePeer::doUpdate($selectCriteria, $criteria, $con);
	

    foreach (sfMixer::getCallables('BaseNewsPeer:doUpdate:post') as $callable)
    {
      call_user_func($callable, 'BaseNewsPeer', $values, $con, $ret);
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
			$affectedRows += BasePeer::doDeleteAll(NewsPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(NewsPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof News) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(NewsPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(News $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(NewsPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(NewsPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(NewsPeer::DATABASE_NAME, NewsPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = NewsPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(NewsPeer::DATABASE_NAME);

		$criteria->add(NewsPeer::ID, $pk);


		$v = NewsPeer::doSelect($criteria, $con);

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
			$criteria->add(NewsPeer::ID, $pks, Criteria::IN);
			$objs = NewsPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseNewsPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'plugins/deppPropelMonitoringBehaviorsPlugin/lib/model/map/NewsMapBuilder.php';
	Propel::registerMapBuilder('plugins.deppPropelMonitoringBehaviorsPlugin.lib.model.map.NewsMapBuilder');
}
