<?php


abstract class BaseTag extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $n_monitoring_users = 0;


	
	protected $is_tmp = 1;


	
	protected $is_triple;


	
	protected $triple_namespace;


	
	protected $triple_key;


	
	protected $triple_value;

	
	protected $collTaggings;

	
	protected $lastTaggingCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getID()
	{

		return $this->id;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getNMonitoringUsers()
	{

		return $this->n_monitoring_users;
	}

	
	public function getIsTmp()
	{

		return $this->is_tmp;
	}

	
	public function getIsTriple()
	{

		return $this->is_triple;
	}

	
	public function getTripleNamespace()
	{

		return $this->triple_namespace;
	}

	
	public function getTripleKey()
	{

		return $this->triple_key;
	}

	
	public function getTripleValue()
	{

		return $this->triple_value;
	}

	
	public function setID($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = TagPeer::ID;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = TagPeer::NAME;
		}

	} 
	
	public function setNMonitoringUsers($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->n_monitoring_users !== $v || $v === 0) {
			$this->n_monitoring_users = $v;
			$this->modifiedColumns[] = TagPeer::N_MONITORING_USERS;
		}

	} 
	
	public function setIsTmp($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->is_tmp !== $v || $v === 1) {
			$this->is_tmp = $v;
			$this->modifiedColumns[] = TagPeer::IS_TMP;
		}

	} 
	
	public function setIsTriple($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->is_triple !== $v) {
			$this->is_triple = $v;
			$this->modifiedColumns[] = TagPeer::IS_TRIPLE;
		}

	} 
	
	public function setTripleNamespace($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->triple_namespace !== $v) {
			$this->triple_namespace = $v;
			$this->modifiedColumns[] = TagPeer::TRIPLE_NAMESPACE;
		}

	} 
	
	public function setTripleKey($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->triple_key !== $v) {
			$this->triple_key = $v;
			$this->modifiedColumns[] = TagPeer::TRIPLE_KEY;
		}

	} 
	
	public function setTripleValue($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->triple_value !== $v) {
			$this->triple_value = $v;
			$this->modifiedColumns[] = TagPeer::TRIPLE_VALUE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->n_monitoring_users = $rs->getInt($startcol + 2);

			$this->is_tmp = $rs->getInt($startcol + 3);

			$this->is_triple = $rs->getInt($startcol + 4);

			$this->triple_namespace = $rs->getString($startcol + 5);

			$this->triple_key = $rs->getString($startcol + 6);

			$this->triple_value = $rs->getString($startcol + 7);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Tag object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseTag:delete:pre') as $callable)
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
			$con = Propel::getConnection(TagPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			TagPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseTag:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseTag:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(TagPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseTag:save:post') as $callable)
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
					$pk = TagPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setID($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += TagPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collTaggings !== null) {
				foreach($this->collTaggings as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

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


			if (($retval = TagPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collTaggings !== null) {
					foreach($this->collTaggings as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TagPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getID();
				break;
			case 1:
				return $this->getName();
				break;
			case 2:
				return $this->getNMonitoringUsers();
				break;
			case 3:
				return $this->getIsTmp();
				break;
			case 4:
				return $this->getIsTriple();
				break;
			case 5:
				return $this->getTripleNamespace();
				break;
			case 6:
				return $this->getTripleKey();
				break;
			case 7:
				return $this->getTripleValue();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TagPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getID(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getNMonitoringUsers(),
			$keys[3] => $this->getIsTmp(),
			$keys[4] => $this->getIsTriple(),
			$keys[5] => $this->getTripleNamespace(),
			$keys[6] => $this->getTripleKey(),
			$keys[7] => $this->getTripleValue(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TagPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setID($value);
				break;
			case 1:
				$this->setName($value);
				break;
			case 2:
				$this->setNMonitoringUsers($value);
				break;
			case 3:
				$this->setIsTmp($value);
				break;
			case 4:
				$this->setIsTriple($value);
				break;
			case 5:
				$this->setTripleNamespace($value);
				break;
			case 6:
				$this->setTripleKey($value);
				break;
			case 7:
				$this->setTripleValue($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TagPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setID($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setNMonitoringUsers($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setIsTmp($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setIsTriple($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setTripleNamespace($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setTripleKey($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setTripleValue($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(TagPeer::DATABASE_NAME);

		if ($this->isColumnModified(TagPeer::ID)) $criteria->add(TagPeer::ID, $this->id);
		if ($this->isColumnModified(TagPeer::NAME)) $criteria->add(TagPeer::NAME, $this->name);
		if ($this->isColumnModified(TagPeer::N_MONITORING_USERS)) $criteria->add(TagPeer::N_MONITORING_USERS, $this->n_monitoring_users);
		if ($this->isColumnModified(TagPeer::IS_TMP)) $criteria->add(TagPeer::IS_TMP, $this->is_tmp);
		if ($this->isColumnModified(TagPeer::IS_TRIPLE)) $criteria->add(TagPeer::IS_TRIPLE, $this->is_triple);
		if ($this->isColumnModified(TagPeer::TRIPLE_NAMESPACE)) $criteria->add(TagPeer::TRIPLE_NAMESPACE, $this->triple_namespace);
		if ($this->isColumnModified(TagPeer::TRIPLE_KEY)) $criteria->add(TagPeer::TRIPLE_KEY, $this->triple_key);
		if ($this->isColumnModified(TagPeer::TRIPLE_VALUE)) $criteria->add(TagPeer::TRIPLE_VALUE, $this->triple_value);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(TagPeer::DATABASE_NAME);

		$criteria->add(TagPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getID();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setID($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setNMonitoringUsers($this->n_monitoring_users);

		$copyObj->setIsTmp($this->is_tmp);

		$copyObj->setIsTriple($this->is_triple);

		$copyObj->setTripleNamespace($this->triple_namespace);

		$copyObj->setTripleKey($this->triple_key);

		$copyObj->setTripleValue($this->triple_value);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getTaggings() as $relObj) {
				$copyObj->addTagging($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setID(NULL); 
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
			self::$peer = new TagPeer();
		}
		return self::$peer;
	}

	
	public function initTaggings()
	{
		if ($this->collTaggings === null) {
			$this->collTaggings = array();
		}
	}

	
	public function getTaggings($criteria = null, $con = null)
	{
				include_once 'plugins/deppPropelActAsTaggableBehaviorPlugin/lib/model/om/BaseTaggingPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collTaggings === null) {
			if ($this->isNew()) {
			   $this->collTaggings = array();
			} else {

				$criteria->add(TaggingPeer::TAG_ID, $this->getID());

				TaggingPeer::addSelectColumns($criteria);
				$this->collTaggings = TaggingPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(TaggingPeer::TAG_ID, $this->getID());

				TaggingPeer::addSelectColumns($criteria);
				if (!isset($this->lastTaggingCriteria) || !$this->lastTaggingCriteria->equals($criteria)) {
					$this->collTaggings = TaggingPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastTaggingCriteria = $criteria;
		return $this->collTaggings;
	}

	
	public function countTaggings($criteria = null, $distinct = false, $con = null)
	{
				include_once 'plugins/deppPropelActAsTaggableBehaviorPlugin/lib/model/om/BaseTaggingPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(TaggingPeer::TAG_ID, $this->getID());

		return TaggingPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addTagging(Tagging $l)
	{
		$this->collTaggings[] = $l;
		$l->setTag($this);
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseTag:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseTag::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 