<?php


abstract class BasesfBookmarking extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $bookmarkable_model;


	
	protected $bookmarkable_id;


	
	protected $user_id;


	
	protected $bookmarking = 1;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getBookmarkableModel()
	{

		return $this->bookmarkable_model;
	}

	
	public function getBookmarkableId()
	{

		return $this->bookmarkable_id;
	}

	
	public function getUserId()
	{

		return $this->user_id;
	}

	
	public function getBookmarking()
	{

		return $this->bookmarking;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = sfBookmarkingPeer::ID;
		}

	} 
	
	public function setBookmarkableModel($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->bookmarkable_model !== $v) {
			$this->bookmarkable_model = $v;
			$this->modifiedColumns[] = sfBookmarkingPeer::BOOKMARKABLE_MODEL;
		}

	} 
	
	public function setBookmarkableId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->bookmarkable_id !== $v) {
			$this->bookmarkable_id = $v;
			$this->modifiedColumns[] = sfBookmarkingPeer::BOOKMARKABLE_ID;
		}

	} 
	
	public function setUserId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = sfBookmarkingPeer::USER_ID;
		}

	} 
	
	public function setBookmarking($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->bookmarking !== $v || $v === 1) {
			$this->bookmarking = $v;
			$this->modifiedColumns[] = sfBookmarkingPeer::BOOKMARKING;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->bookmarkable_model = $rs->getString($startcol + 1);

			$this->bookmarkable_id = $rs->getInt($startcol + 2);

			$this->user_id = $rs->getInt($startcol + 3);

			$this->bookmarking = $rs->getInt($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfBookmarking object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfBookmarking:delete:pre') as $callable)
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
			$con = Propel::getConnection(sfBookmarkingPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfBookmarkingPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfBookmarking:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfBookmarking:save:pre') as $callable)
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
			$con = Propel::getConnection(sfBookmarkingPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfBookmarking:save:post') as $callable)
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
					$pk = sfBookmarkingPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += sfBookmarkingPeer::doUpdate($this, $con);
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


			if (($retval = sfBookmarkingPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfBookmarkingPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getBookmarkableModel();
				break;
			case 2:
				return $this->getBookmarkableId();
				break;
			case 3:
				return $this->getUserId();
				break;
			case 4:
				return $this->getBookmarking();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfBookmarkingPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getBookmarkableModel(),
			$keys[2] => $this->getBookmarkableId(),
			$keys[3] => $this->getUserId(),
			$keys[4] => $this->getBookmarking(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfBookmarkingPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setBookmarkableModel($value);
				break;
			case 2:
				$this->setBookmarkableId($value);
				break;
			case 3:
				$this->setUserId($value);
				break;
			case 4:
				$this->setBookmarking($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfBookmarkingPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setBookmarkableModel($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setBookmarkableId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setUserId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setBookmarking($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfBookmarkingPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfBookmarkingPeer::ID)) $criteria->add(sfBookmarkingPeer::ID, $this->id);
		if ($this->isColumnModified(sfBookmarkingPeer::BOOKMARKABLE_MODEL)) $criteria->add(sfBookmarkingPeer::BOOKMARKABLE_MODEL, $this->bookmarkable_model);
		if ($this->isColumnModified(sfBookmarkingPeer::BOOKMARKABLE_ID)) $criteria->add(sfBookmarkingPeer::BOOKMARKABLE_ID, $this->bookmarkable_id);
		if ($this->isColumnModified(sfBookmarkingPeer::USER_ID)) $criteria->add(sfBookmarkingPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(sfBookmarkingPeer::BOOKMARKING)) $criteria->add(sfBookmarkingPeer::BOOKMARKING, $this->bookmarking);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfBookmarkingPeer::DATABASE_NAME);

		$criteria->add(sfBookmarkingPeer::ID, $this->id);

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

		$copyObj->setBookmarkableModel($this->bookmarkable_model);

		$copyObj->setBookmarkableId($this->bookmarkable_id);

		$copyObj->setUserId($this->user_id);

		$copyObj->setBookmarking($this->bookmarking);


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
			self::$peer = new sfBookmarkingPeer();
		}
		return self::$peer;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfBookmarking:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfBookmarking::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 