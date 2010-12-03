<?php


abstract class BasesfRating extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $ratable_model;


	
	protected $ratable_id;


	
	protected $user_id;


	
	protected $rating = 1;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getRatableModel()
	{

		return $this->ratable_model;
	}

	
	public function getRatableId()
	{

		return $this->ratable_id;
	}

	
	public function getUserId()
	{

		return $this->user_id;
	}

	
	public function getRating()
	{

		return $this->rating;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = sfRatingPeer::ID;
		}

	} 
	
	public function setRatableModel($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->ratable_model !== $v) {
			$this->ratable_model = $v;
			$this->modifiedColumns[] = sfRatingPeer::RATABLE_MODEL;
		}

	} 
	
	public function setRatableId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ratable_id !== $v) {
			$this->ratable_id = $v;
			$this->modifiedColumns[] = sfRatingPeer::RATABLE_ID;
		}

	} 
	
	public function setUserId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = sfRatingPeer::USER_ID;
		}

	} 
	
	public function setRating($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->rating !== $v || $v === 1) {
			$this->rating = $v;
			$this->modifiedColumns[] = sfRatingPeer::RATING;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->ratable_model = $rs->getString($startcol + 1);

			$this->ratable_id = $rs->getInt($startcol + 2);

			$this->user_id = $rs->getInt($startcol + 3);

			$this->rating = $rs->getInt($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfRating object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfRating:delete:pre') as $callable)
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
			$con = Propel::getConnection(sfRatingPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfRatingPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfRating:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfRating:save:pre') as $callable)
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
			$con = Propel::getConnection(sfRatingPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfRating:save:post') as $callable)
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
					$pk = sfRatingPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += sfRatingPeer::doUpdate($this, $con);
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


			if (($retval = sfRatingPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfRatingPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getRatableModel();
				break;
			case 2:
				return $this->getRatableId();
				break;
			case 3:
				return $this->getUserId();
				break;
			case 4:
				return $this->getRating();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfRatingPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getRatableModel(),
			$keys[2] => $this->getRatableId(),
			$keys[3] => $this->getUserId(),
			$keys[4] => $this->getRating(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfRatingPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setRatableModel($value);
				break;
			case 2:
				$this->setRatableId($value);
				break;
			case 3:
				$this->setUserId($value);
				break;
			case 4:
				$this->setRating($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfRatingPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setRatableModel($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setRatableId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setUserId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setRating($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfRatingPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfRatingPeer::ID)) $criteria->add(sfRatingPeer::ID, $this->id);
		if ($this->isColumnModified(sfRatingPeer::RATABLE_MODEL)) $criteria->add(sfRatingPeer::RATABLE_MODEL, $this->ratable_model);
		if ($this->isColumnModified(sfRatingPeer::RATABLE_ID)) $criteria->add(sfRatingPeer::RATABLE_ID, $this->ratable_id);
		if ($this->isColumnModified(sfRatingPeer::USER_ID)) $criteria->add(sfRatingPeer::USER_ID, $this->user_id);
		if ($this->isColumnModified(sfRatingPeer::RATING)) $criteria->add(sfRatingPeer::RATING, $this->rating);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfRatingPeer::DATABASE_NAME);

		$criteria->add(sfRatingPeer::ID, $this->id);

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

		$copyObj->setRatableModel($this->ratable_model);

		$copyObj->setRatableId($this->ratable_id);

		$copyObj->setUserId($this->user_id);

		$copyObj->setRating($this->rating);


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
			self::$peer = new sfRatingPeer();
		}
		return self::$peer;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfRating:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfRating::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 