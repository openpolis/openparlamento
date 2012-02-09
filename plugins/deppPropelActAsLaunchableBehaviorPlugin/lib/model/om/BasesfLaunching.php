<?php


abstract class BasesfLaunching extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $object_model;


	
	protected $object_id;


	
	protected $launch_namespace = 'home';


	
	protected $created_at;


	
	protected $priority = 0;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getObjectModel()
	{

		return $this->object_model;
	}

	
	public function getObjectId()
	{

		return $this->object_id;
	}

	
	public function getLaunchNamespace()
	{

		return $this->launch_namespace;
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

	
	public function getPriority()
	{

		return $this->priority;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = sfLaunchingPeer::ID;
		}

	} 
	
	public function setObjectModel($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->object_model !== $v) {
			$this->object_model = $v;
			$this->modifiedColumns[] = sfLaunchingPeer::OBJECT_MODEL;
		}

	} 
	
	public function setObjectId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->object_id !== $v) {
			$this->object_id = $v;
			$this->modifiedColumns[] = sfLaunchingPeer::OBJECT_ID;
		}

	} 
	
	public function setLaunchNamespace($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->launch_namespace !== $v || $v === 'home') {
			$this->launch_namespace = $v;
			$this->modifiedColumns[] = sfLaunchingPeer::LAUNCH_NAMESPACE;
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
			$this->modifiedColumns[] = sfLaunchingPeer::CREATED_AT;
		}

	} 
	
	public function setPriority($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->priority !== $v || $v === 0) {
			$this->priority = $v;
			$this->modifiedColumns[] = sfLaunchingPeer::PRIORITY;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->object_model = $rs->getString($startcol + 1);

			$this->object_id = $rs->getInt($startcol + 2);

			$this->launch_namespace = $rs->getString($startcol + 3);

			$this->created_at = $rs->getTimestamp($startcol + 4, null);

			$this->priority = $rs->getInt($startcol + 5);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfLaunching object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfLaunching:delete:pre') as $callable)
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
			$con = Propel::getConnection(sfLaunchingPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfLaunchingPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfLaunching:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfLaunching:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(sfLaunchingPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfLaunchingPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfLaunching:save:post') as $callable)
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
					$pk = sfLaunchingPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += sfLaunchingPeer::doUpdate($this, $con);
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


			if (($retval = sfLaunchingPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfLaunchingPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getObjectModel();
				break;
			case 2:
				return $this->getObjectId();
				break;
			case 3:
				return $this->getLaunchNamespace();
				break;
			case 4:
				return $this->getCreatedAt();
				break;
			case 5:
				return $this->getPriority();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfLaunchingPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getObjectModel(),
			$keys[2] => $this->getObjectId(),
			$keys[3] => $this->getLaunchNamespace(),
			$keys[4] => $this->getCreatedAt(),
			$keys[5] => $this->getPriority(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfLaunchingPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setObjectModel($value);
				break;
			case 2:
				$this->setObjectId($value);
				break;
			case 3:
				$this->setLaunchNamespace($value);
				break;
			case 4:
				$this->setCreatedAt($value);
				break;
			case 5:
				$this->setPriority($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfLaunchingPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setObjectModel($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setObjectId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setLaunchNamespace($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setCreatedAt($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPriority($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfLaunchingPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfLaunchingPeer::ID)) $criteria->add(sfLaunchingPeer::ID, $this->id);
		if ($this->isColumnModified(sfLaunchingPeer::OBJECT_MODEL)) $criteria->add(sfLaunchingPeer::OBJECT_MODEL, $this->object_model);
		if ($this->isColumnModified(sfLaunchingPeer::OBJECT_ID)) $criteria->add(sfLaunchingPeer::OBJECT_ID, $this->object_id);
		if ($this->isColumnModified(sfLaunchingPeer::LAUNCH_NAMESPACE)) $criteria->add(sfLaunchingPeer::LAUNCH_NAMESPACE, $this->launch_namespace);
		if ($this->isColumnModified(sfLaunchingPeer::CREATED_AT)) $criteria->add(sfLaunchingPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(sfLaunchingPeer::PRIORITY)) $criteria->add(sfLaunchingPeer::PRIORITY, $this->priority);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfLaunchingPeer::DATABASE_NAME);

		$criteria->add(sfLaunchingPeer::ID, $this->id);

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

		$copyObj->setObjectModel($this->object_model);

		$copyObj->setObjectId($this->object_id);

		$copyObj->setLaunchNamespace($this->launch_namespace);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setPriority($this->priority);


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
			self::$peer = new sfLaunchingPeer();
		}
		return self::$peer;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfLaunching:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfLaunching::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 