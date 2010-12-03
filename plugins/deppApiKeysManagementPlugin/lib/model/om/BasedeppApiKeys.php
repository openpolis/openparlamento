<?php


abstract class BasedeppApiKeys extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $req_name = '';


	
	protected $req_contact = '';


	
	protected $req_description;


	
	protected $value;


	
	protected $requested_at;


	
	protected $granted_at;


	
	protected $revoked_at;


	
	protected $refused_at;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getReqName()
	{

		return $this->req_name;
	}

	
	public function getReqContact()
	{

		return $this->req_contact;
	}

	
	public function getReqDescription()
	{

		return $this->req_description;
	}

	
	public function getValue()
	{

		return $this->value;
	}

	
	public function getRequestedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->requested_at === null || $this->requested_at === '') {
			return null;
		} elseif (!is_int($this->requested_at)) {
						$ts = strtotime($this->requested_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [requested_at] as date/time value: " . var_export($this->requested_at, true));
			}
		} else {
			$ts = $this->requested_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getGrantedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->granted_at === null || $this->granted_at === '') {
			return null;
		} elseif (!is_int($this->granted_at)) {
						$ts = strtotime($this->granted_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [granted_at] as date/time value: " . var_export($this->granted_at, true));
			}
		} else {
			$ts = $this->granted_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getRevokedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->revoked_at === null || $this->revoked_at === '') {
			return null;
		} elseif (!is_int($this->revoked_at)) {
						$ts = strtotime($this->revoked_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [revoked_at] as date/time value: " . var_export($this->revoked_at, true));
			}
		} else {
			$ts = $this->revoked_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getRefusedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->refused_at === null || $this->refused_at === '') {
			return null;
		} elseif (!is_int($this->refused_at)) {
						$ts = strtotime($this->refused_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [refused_at] as date/time value: " . var_export($this->refused_at, true));
			}
		} else {
			$ts = $this->refused_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = deppApiKeysPeer::ID;
		}

	} 
	
	public function setReqName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->req_name !== $v || $v === '') {
			$this->req_name = $v;
			$this->modifiedColumns[] = deppApiKeysPeer::REQ_NAME;
		}

	} 
	
	public function setReqContact($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->req_contact !== $v || $v === '') {
			$this->req_contact = $v;
			$this->modifiedColumns[] = deppApiKeysPeer::REQ_CONTACT;
		}

	} 
	
	public function setReqDescription($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->req_description !== $v) {
			$this->req_description = $v;
			$this->modifiedColumns[] = deppApiKeysPeer::REQ_DESCRIPTION;
		}

	} 
	
	public function setValue($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->value !== $v) {
			$this->value = $v;
			$this->modifiedColumns[] = deppApiKeysPeer::VALUE;
		}

	} 
	
	public function setRequestedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [requested_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->requested_at !== $ts) {
			$this->requested_at = $ts;
			$this->modifiedColumns[] = deppApiKeysPeer::REQUESTED_AT;
		}

	} 
	
	public function setGrantedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [granted_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->granted_at !== $ts) {
			$this->granted_at = $ts;
			$this->modifiedColumns[] = deppApiKeysPeer::GRANTED_AT;
		}

	} 
	
	public function setRevokedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [revoked_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->revoked_at !== $ts) {
			$this->revoked_at = $ts;
			$this->modifiedColumns[] = deppApiKeysPeer::REVOKED_AT;
		}

	} 
	
	public function setRefusedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [refused_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->refused_at !== $ts) {
			$this->refused_at = $ts;
			$this->modifiedColumns[] = deppApiKeysPeer::REFUSED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->req_name = $rs->getString($startcol + 1);

			$this->req_contact = $rs->getString($startcol + 2);

			$this->req_description = $rs->getString($startcol + 3);

			$this->value = $rs->getString($startcol + 4);

			$this->requested_at = $rs->getTimestamp($startcol + 5, null);

			$this->granted_at = $rs->getTimestamp($startcol + 6, null);

			$this->revoked_at = $rs->getTimestamp($startcol + 7, null);

			$this->refused_at = $rs->getTimestamp($startcol + 8, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 9; 
		} catch (Exception $e) {
			throw new PropelException("Error populating deppApiKeys object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasedeppApiKeys:delete:pre') as $callable)
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
			$con = Propel::getConnection(deppApiKeysPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			deppApiKeysPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasedeppApiKeys:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasedeppApiKeys:save:pre') as $callable)
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
			$con = Propel::getConnection(deppApiKeysPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasedeppApiKeys:save:post') as $callable)
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
					$pk = deppApiKeysPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += deppApiKeysPeer::doUpdate($this, $con);
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


			if (($retval = deppApiKeysPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = deppApiKeysPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getReqName();
				break;
			case 2:
				return $this->getReqContact();
				break;
			case 3:
				return $this->getReqDescription();
				break;
			case 4:
				return $this->getValue();
				break;
			case 5:
				return $this->getRequestedAt();
				break;
			case 6:
				return $this->getGrantedAt();
				break;
			case 7:
				return $this->getRevokedAt();
				break;
			case 8:
				return $this->getRefusedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = deppApiKeysPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getReqName(),
			$keys[2] => $this->getReqContact(),
			$keys[3] => $this->getReqDescription(),
			$keys[4] => $this->getValue(),
			$keys[5] => $this->getRequestedAt(),
			$keys[6] => $this->getGrantedAt(),
			$keys[7] => $this->getRevokedAt(),
			$keys[8] => $this->getRefusedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = deppApiKeysPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setReqName($value);
				break;
			case 2:
				$this->setReqContact($value);
				break;
			case 3:
				$this->setReqDescription($value);
				break;
			case 4:
				$this->setValue($value);
				break;
			case 5:
				$this->setRequestedAt($value);
				break;
			case 6:
				$this->setGrantedAt($value);
				break;
			case 7:
				$this->setRevokedAt($value);
				break;
			case 8:
				$this->setRefusedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = deppApiKeysPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setReqName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setReqContact($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setReqDescription($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setValue($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setRequestedAt($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setGrantedAt($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setRevokedAt($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setRefusedAt($arr[$keys[8]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(deppApiKeysPeer::DATABASE_NAME);

		if ($this->isColumnModified(deppApiKeysPeer::ID)) $criteria->add(deppApiKeysPeer::ID, $this->id);
		if ($this->isColumnModified(deppApiKeysPeer::REQ_NAME)) $criteria->add(deppApiKeysPeer::REQ_NAME, $this->req_name);
		if ($this->isColumnModified(deppApiKeysPeer::REQ_CONTACT)) $criteria->add(deppApiKeysPeer::REQ_CONTACT, $this->req_contact);
		if ($this->isColumnModified(deppApiKeysPeer::REQ_DESCRIPTION)) $criteria->add(deppApiKeysPeer::REQ_DESCRIPTION, $this->req_description);
		if ($this->isColumnModified(deppApiKeysPeer::VALUE)) $criteria->add(deppApiKeysPeer::VALUE, $this->value);
		if ($this->isColumnModified(deppApiKeysPeer::REQUESTED_AT)) $criteria->add(deppApiKeysPeer::REQUESTED_AT, $this->requested_at);
		if ($this->isColumnModified(deppApiKeysPeer::GRANTED_AT)) $criteria->add(deppApiKeysPeer::GRANTED_AT, $this->granted_at);
		if ($this->isColumnModified(deppApiKeysPeer::REVOKED_AT)) $criteria->add(deppApiKeysPeer::REVOKED_AT, $this->revoked_at);
		if ($this->isColumnModified(deppApiKeysPeer::REFUSED_AT)) $criteria->add(deppApiKeysPeer::REFUSED_AT, $this->refused_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(deppApiKeysPeer::DATABASE_NAME);

		$criteria->add(deppApiKeysPeer::ID, $this->id);

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

		$copyObj->setReqName($this->req_name);

		$copyObj->setReqContact($this->req_contact);

		$copyObj->setReqDescription($this->req_description);

		$copyObj->setValue($this->value);

		$copyObj->setRequestedAt($this->requested_at);

		$copyObj->setGrantedAt($this->granted_at);

		$copyObj->setRevokedAt($this->revoked_at);

		$copyObj->setRefusedAt($this->refused_at);


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
			self::$peer = new deppApiKeysPeer();
		}
		return self::$peer;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasedeppApiKeys:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasedeppApiKeys::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 