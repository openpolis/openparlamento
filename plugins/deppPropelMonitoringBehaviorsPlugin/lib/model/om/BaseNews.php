<?php


abstract class BaseNews extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $created_at;


	
	protected $generator_model;


	
	protected $generator_primary_keys;


	
	protected $related_monitorable_model;


	
	protected $related_monitorable_id;


	
	protected $date;


	
	protected $priority = 0;


	
	protected $tipo_atto_id;


	
	protected $data_presentazione_atto;


	
	protected $ramo_votazione;


	
	protected $sede_intervento_id;


	
	protected $succ;


	
	protected $tag_id;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
						$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getGeneratorModel()
	{

		return $this->generator_model;
	}

	
	public function getGeneratorPrimaryKeys()
	{

		return $this->generator_primary_keys;
	}

	
	public function getRelatedMonitorableModel()
	{

		return $this->related_monitorable_model;
	}

	
	public function getRelatedMonitorableId()
	{

		return $this->related_monitorable_id;
	}

	
	public function getDate($format = 'Y-m-d H:i:s')
	{

		if ($this->date === null || $this->date === '') {
			return null;
		} elseif (!is_int($this->date)) {
						$ts = strtotime($this->date);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [date] as date/time value: " . var_export($this->date, true));
			}
		} else {
			$ts = $this->date;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getPriority()
	{

		return $this->priority;
	}

	
	public function getTipoAttoId()
	{

		return $this->tipo_atto_id;
	}

	
	public function getDataPresentazioneAtto($format = 'Y-m-d H:i:s')
	{

		if ($this->data_presentazione_atto === null || $this->data_presentazione_atto === '') {
			return null;
		} elseif (!is_int($this->data_presentazione_atto)) {
						$ts = strtotime($this->data_presentazione_atto);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [data_presentazione_atto] as date/time value: " . var_export($this->data_presentazione_atto, true));
			}
		} else {
			$ts = $this->data_presentazione_atto;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getRamoVotazione()
	{

		return $this->ramo_votazione;
	}

	
	public function getSedeInterventoId()
	{

		return $this->sede_intervento_id;
	}

	
	public function getSucc()
	{

		return $this->succ;
	}

	
	public function getTagId()
	{

		return $this->tag_id;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = NewsPeer::ID;
		}

	} 
	
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = NewsPeer::CREATED_AT;
		}

	} 
	
	public function setGeneratorModel($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->generator_model !== $v) {
			$this->generator_model = $v;
			$this->modifiedColumns[] = NewsPeer::GENERATOR_MODEL;
		}

	} 
	
	public function setGeneratorPrimaryKeys($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->generator_primary_keys !== $v) {
			$this->generator_primary_keys = $v;
			$this->modifiedColumns[] = NewsPeer::GENERATOR_PRIMARY_KEYS;
		}

	} 
	
	public function setRelatedMonitorableModel($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->related_monitorable_model !== $v) {
			$this->related_monitorable_model = $v;
			$this->modifiedColumns[] = NewsPeer::RELATED_MONITORABLE_MODEL;
		}

	} 
	
	public function setRelatedMonitorableId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->related_monitorable_id !== $v) {
			$this->related_monitorable_id = $v;
			$this->modifiedColumns[] = NewsPeer::RELATED_MONITORABLE_ID;
		}

	} 
	
	public function setDate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [date] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->date !== $ts) {
			$this->date = $ts;
			$this->modifiedColumns[] = NewsPeer::DATE;
		}

	} 
	
	public function setPriority($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->priority !== $v || $v === 0) {
			$this->priority = $v;
			$this->modifiedColumns[] = NewsPeer::PRIORITY;
		}

	} 
	
	public function setTipoAttoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->tipo_atto_id !== $v) {
			$this->tipo_atto_id = $v;
			$this->modifiedColumns[] = NewsPeer::TIPO_ATTO_ID;
		}

	} 
	
	public function setDataPresentazioneAtto($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [data_presentazione_atto] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->data_presentazione_atto !== $ts) {
			$this->data_presentazione_atto = $ts;
			$this->modifiedColumns[] = NewsPeer::DATA_PRESENTAZIONE_ATTO;
		}

	} 
	
	public function setRamoVotazione($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->ramo_votazione !== $v) {
			$this->ramo_votazione = $v;
			$this->modifiedColumns[] = NewsPeer::RAMO_VOTAZIONE;
		}

	} 
	
	public function setSedeInterventoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->sede_intervento_id !== $v) {
			$this->sede_intervento_id = $v;
			$this->modifiedColumns[] = NewsPeer::SEDE_INTERVENTO_ID;
		}

	} 
	
	public function setSucc($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->succ !== $v) {
			$this->succ = $v;
			$this->modifiedColumns[] = NewsPeer::SUCC;
		}

	} 
	
	public function setTagId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->tag_id !== $v) {
			$this->tag_id = $v;
			$this->modifiedColumns[] = NewsPeer::TAG_ID;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->created_at = $rs->getTimestamp($startcol + 1, null);

			$this->generator_model = $rs->getString($startcol + 2);

			$this->generator_primary_keys = $rs->getString($startcol + 3);

			$this->related_monitorable_model = $rs->getString($startcol + 4);

			$this->related_monitorable_id = $rs->getInt($startcol + 5);

			$this->date = $rs->getTimestamp($startcol + 6, null);

			$this->priority = $rs->getInt($startcol + 7);

			$this->tipo_atto_id = $rs->getInt($startcol + 8);

			$this->data_presentazione_atto = $rs->getTimestamp($startcol + 9, null);

			$this->ramo_votazione = $rs->getString($startcol + 10);

			$this->sede_intervento_id = $rs->getInt($startcol + 11);

			$this->succ = $rs->getInt($startcol + 12);

			$this->tag_id = $rs->getInt($startcol + 13);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 14; 
		} catch (Exception $e) {
			throw new PropelException("Error populating News object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseNews:delete:pre') as $callable)
    {
      $ret = call_user_func($callable, $this, $con);
      if ($ret)
      {
        return;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(NewsPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			NewsPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseNews:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseNews:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(NewsPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(NewsPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseNews:save:post') as $callable)
    {
      call_user_func($callable, $this, $con, $affectedRows);
    }

			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = NewsPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += NewsPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


			if (($retval = NewsPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = NewsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getCreatedAt();
				break;
			case 2:
				return $this->getGeneratorModel();
				break;
			case 3:
				return $this->getGeneratorPrimaryKeys();
				break;
			case 4:
				return $this->getRelatedMonitorableModel();
				break;
			case 5:
				return $this->getRelatedMonitorableId();
				break;
			case 6:
				return $this->getDate();
				break;
			case 7:
				return $this->getPriority();
				break;
			case 8:
				return $this->getTipoAttoId();
				break;
			case 9:
				return $this->getDataPresentazioneAtto();
				break;
			case 10:
				return $this->getRamoVotazione();
				break;
			case 11:
				return $this->getSedeInterventoId();
				break;
			case 12:
				return $this->getSucc();
				break;
			case 13:
				return $this->getTagId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = NewsPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCreatedAt(),
			$keys[2] => $this->getGeneratorModel(),
			$keys[3] => $this->getGeneratorPrimaryKeys(),
			$keys[4] => $this->getRelatedMonitorableModel(),
			$keys[5] => $this->getRelatedMonitorableId(),
			$keys[6] => $this->getDate(),
			$keys[7] => $this->getPriority(),
			$keys[8] => $this->getTipoAttoId(),
			$keys[9] => $this->getDataPresentazioneAtto(),
			$keys[10] => $this->getRamoVotazione(),
			$keys[11] => $this->getSedeInterventoId(),
			$keys[12] => $this->getSucc(),
			$keys[13] => $this->getTagId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = NewsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setCreatedAt($value);
				break;
			case 2:
				$this->setGeneratorModel($value);
				break;
			case 3:
				$this->setGeneratorPrimaryKeys($value);
				break;
			case 4:
				$this->setRelatedMonitorableModel($value);
				break;
			case 5:
				$this->setRelatedMonitorableId($value);
				break;
			case 6:
				$this->setDate($value);
				break;
			case 7:
				$this->setPriority($value);
				break;
			case 8:
				$this->setTipoAttoId($value);
				break;
			case 9:
				$this->setDataPresentazioneAtto($value);
				break;
			case 10:
				$this->setRamoVotazione($value);
				break;
			case 11:
				$this->setSedeInterventoId($value);
				break;
			case 12:
				$this->setSucc($value);
				break;
			case 13:
				$this->setTagId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = NewsPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCreatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setGeneratorModel($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setGeneratorPrimaryKeys($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setRelatedMonitorableModel($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setRelatedMonitorableId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setDate($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPriority($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setTipoAttoId($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setDataPresentazioneAtto($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setRamoVotazione($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setSedeInterventoId($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setSucc($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setTagId($arr[$keys[13]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(NewsPeer::DATABASE_NAME);

		if ($this->isColumnModified(NewsPeer::ID)) $criteria->add(NewsPeer::ID, $this->id);
		if ($this->isColumnModified(NewsPeer::CREATED_AT)) $criteria->add(NewsPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(NewsPeer::GENERATOR_MODEL)) $criteria->add(NewsPeer::GENERATOR_MODEL, $this->generator_model);
		if ($this->isColumnModified(NewsPeer::GENERATOR_PRIMARY_KEYS)) $criteria->add(NewsPeer::GENERATOR_PRIMARY_KEYS, $this->generator_primary_keys);
		if ($this->isColumnModified(NewsPeer::RELATED_MONITORABLE_MODEL)) $criteria->add(NewsPeer::RELATED_MONITORABLE_MODEL, $this->related_monitorable_model);
		if ($this->isColumnModified(NewsPeer::RELATED_MONITORABLE_ID)) $criteria->add(NewsPeer::RELATED_MONITORABLE_ID, $this->related_monitorable_id);
		if ($this->isColumnModified(NewsPeer::DATE)) $criteria->add(NewsPeer::DATE, $this->date);
		if ($this->isColumnModified(NewsPeer::PRIORITY)) $criteria->add(NewsPeer::PRIORITY, $this->priority);
		if ($this->isColumnModified(NewsPeer::TIPO_ATTO_ID)) $criteria->add(NewsPeer::TIPO_ATTO_ID, $this->tipo_atto_id);
		if ($this->isColumnModified(NewsPeer::DATA_PRESENTAZIONE_ATTO)) $criteria->add(NewsPeer::DATA_PRESENTAZIONE_ATTO, $this->data_presentazione_atto);
		if ($this->isColumnModified(NewsPeer::RAMO_VOTAZIONE)) $criteria->add(NewsPeer::RAMO_VOTAZIONE, $this->ramo_votazione);
		if ($this->isColumnModified(NewsPeer::SEDE_INTERVENTO_ID)) $criteria->add(NewsPeer::SEDE_INTERVENTO_ID, $this->sede_intervento_id);
		if ($this->isColumnModified(NewsPeer::SUCC)) $criteria->add(NewsPeer::SUCC, $this->succ);
		if ($this->isColumnModified(NewsPeer::TAG_ID)) $criteria->add(NewsPeer::TAG_ID, $this->tag_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(NewsPeer::DATABASE_NAME);

		$criteria->add(NewsPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setGeneratorModel($this->generator_model);

		$copyObj->setGeneratorPrimaryKeys($this->generator_primary_keys);

		$copyObj->setRelatedMonitorableModel($this->related_monitorable_model);

		$copyObj->setRelatedMonitorableId($this->related_monitorable_id);

		$copyObj->setDate($this->date);

		$copyObj->setPriority($this->priority);

		$copyObj->setTipoAttoId($this->tipo_atto_id);

		$copyObj->setDataPresentazioneAtto($this->data_presentazione_atto);

		$copyObj->setRamoVotazione($this->ramo_votazione);

		$copyObj->setSedeInterventoId($this->sede_intervento_id);

		$copyObj->setSucc($this->succ);

		$copyObj->setTagId($this->tag_id);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new NewsPeer();
		}
		return self::$peer;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseNews:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseNews::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 