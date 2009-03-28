<?php


abstract class BaseCommunityNews extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $created_at;


	
	protected $generator_model;


	
	protected $generator_primary_keys;


	
	protected $related_model;


	
	protected $related_id;


	
	protected $username;


	
	protected $type;


	
	protected $vote;


	
	protected $total;

	
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

	
	public function getRelatedModel()
	{

		return $this->related_model;
	}

	
	public function getRelatedId()
	{

		return $this->related_id;
	}

	
	public function getUsername()
	{

		return $this->username;
	}

	
	public function getType()
	{

		return $this->type;
	}

	
	public function getVote()
	{

		return $this->vote;
	}

	
	public function getTotal()
	{

		return $this->total;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = CommunityNewsPeer::ID;
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
			$this->modifiedColumns[] = CommunityNewsPeer::CREATED_AT;
		}

	} 
	
	public function setGeneratorModel($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->generator_model !== $v) {
			$this->generator_model = $v;
			$this->modifiedColumns[] = CommunityNewsPeer::GENERATOR_MODEL;
		}

	} 
	
	public function setGeneratorPrimaryKeys($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->generator_primary_keys !== $v) {
			$this->generator_primary_keys = $v;
			$this->modifiedColumns[] = CommunityNewsPeer::GENERATOR_PRIMARY_KEYS;
		}

	} 
	
	public function setRelatedModel($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->related_model !== $v) {
			$this->related_model = $v;
			$this->modifiedColumns[] = CommunityNewsPeer::RELATED_MODEL;
		}

	} 
	
	public function setRelatedId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->related_id !== $v) {
			$this->related_id = $v;
			$this->modifiedColumns[] = CommunityNewsPeer::RELATED_ID;
		}

	} 
	
	public function setUsername($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->username !== $v) {
			$this->username = $v;
			$this->modifiedColumns[] = CommunityNewsPeer::USERNAME;
		}

	} 
	
	public function setType($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->type !== $v) {
			$this->type = $v;
			$this->modifiedColumns[] = CommunityNewsPeer::TYPE;
		}

	} 
	
	public function setVote($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->vote !== $v) {
			$this->vote = $v;
			$this->modifiedColumns[] = CommunityNewsPeer::VOTE;
		}

	} 
	
	public function setTotal($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->total !== $v) {
			$this->total = $v;
			$this->modifiedColumns[] = CommunityNewsPeer::TOTAL;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->created_at = $rs->getTimestamp($startcol + 1, null);

			$this->generator_model = $rs->getString($startcol + 2);

			$this->generator_primary_keys = $rs->getString($startcol + 3);

			$this->related_model = $rs->getString($startcol + 4);

			$this->related_id = $rs->getInt($startcol + 5);

			$this->username = $rs->getString($startcol + 6);

			$this->type = $rs->getString($startcol + 7);

			$this->vote = $rs->getInt($startcol + 8);

			$this->total = $rs->getInt($startcol + 9);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 10; 
		} catch (Exception $e) {
			throw new PropelException("Error populating CommunityNews object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseCommunityNews:delete:pre') as $callable)
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
			$con = Propel::getConnection(CommunityNewsPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			CommunityNewsPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseCommunityNews:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseCommunityNews:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(CommunityNewsPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(CommunityNewsPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseCommunityNews:save:post') as $callable)
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
					$pk = CommunityNewsPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += CommunityNewsPeer::doUpdate($this, $con);
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


			if (($retval = CommunityNewsPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CommunityNewsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getRelatedModel();
				break;
			case 5:
				return $this->getRelatedId();
				break;
			case 6:
				return $this->getUsername();
				break;
			case 7:
				return $this->getType();
				break;
			case 8:
				return $this->getVote();
				break;
			case 9:
				return $this->getTotal();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = CommunityNewsPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCreatedAt(),
			$keys[2] => $this->getGeneratorModel(),
			$keys[3] => $this->getGeneratorPrimaryKeys(),
			$keys[4] => $this->getRelatedModel(),
			$keys[5] => $this->getRelatedId(),
			$keys[6] => $this->getUsername(),
			$keys[7] => $this->getType(),
			$keys[8] => $this->getVote(),
			$keys[9] => $this->getTotal(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CommunityNewsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setRelatedModel($value);
				break;
			case 5:
				$this->setRelatedId($value);
				break;
			case 6:
				$this->setUsername($value);
				break;
			case 7:
				$this->setType($value);
				break;
			case 8:
				$this->setVote($value);
				break;
			case 9:
				$this->setTotal($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = CommunityNewsPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCreatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setGeneratorModel($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setGeneratorPrimaryKeys($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setRelatedModel($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setRelatedId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setUsername($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setType($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setVote($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setTotal($arr[$keys[9]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(CommunityNewsPeer::DATABASE_NAME);

		if ($this->isColumnModified(CommunityNewsPeer::ID)) $criteria->add(CommunityNewsPeer::ID, $this->id);
		if ($this->isColumnModified(CommunityNewsPeer::CREATED_AT)) $criteria->add(CommunityNewsPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(CommunityNewsPeer::GENERATOR_MODEL)) $criteria->add(CommunityNewsPeer::GENERATOR_MODEL, $this->generator_model);
		if ($this->isColumnModified(CommunityNewsPeer::GENERATOR_PRIMARY_KEYS)) $criteria->add(CommunityNewsPeer::GENERATOR_PRIMARY_KEYS, $this->generator_primary_keys);
		if ($this->isColumnModified(CommunityNewsPeer::RELATED_MODEL)) $criteria->add(CommunityNewsPeer::RELATED_MODEL, $this->related_model);
		if ($this->isColumnModified(CommunityNewsPeer::RELATED_ID)) $criteria->add(CommunityNewsPeer::RELATED_ID, $this->related_id);
		if ($this->isColumnModified(CommunityNewsPeer::USERNAME)) $criteria->add(CommunityNewsPeer::USERNAME, $this->username);
		if ($this->isColumnModified(CommunityNewsPeer::TYPE)) $criteria->add(CommunityNewsPeer::TYPE, $this->type);
		if ($this->isColumnModified(CommunityNewsPeer::VOTE)) $criteria->add(CommunityNewsPeer::VOTE, $this->vote);
		if ($this->isColumnModified(CommunityNewsPeer::TOTAL)) $criteria->add(CommunityNewsPeer::TOTAL, $this->total);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(CommunityNewsPeer::DATABASE_NAME);

		$criteria->add(CommunityNewsPeer::ID, $this->id);

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

		$copyObj->setRelatedModel($this->related_model);

		$copyObj->setRelatedId($this->related_id);

		$copyObj->setUsername($this->username);

		$copyObj->setType($this->type);

		$copyObj->setVote($this->vote);

		$copyObj->setTotal($this->total);


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
			self::$peer = new CommunityNewsPeer();
		}
		return self::$peer;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseCommunityNews:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseCommunityNews::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 