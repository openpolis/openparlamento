<?php


abstract class BaseTagging extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $tag_id;


	
	protected $taggable_model;


	
	protected $taggable_id;


	
	protected $user_id;

	
	protected $aTag;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getID()
	{

		return $this->id;
	}

	
	public function getTagId()
	{

		return $this->tag_id;
	}

	
	public function getTaggableModel()
	{

		return $this->taggable_model;
	}

	
	public function getTaggableId()
	{

		return $this->taggable_id;
	}

	
	public function getUserId()
	{

		return $this->user_id;
	}

	
	public function setID($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = TaggingPeer::ID;
		}

	} 
	
	public function setTagId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->tag_id !== $v) {
			$this->tag_id = $v;
			$this->modifiedColumns[] = TaggingPeer::TAG_ID;
		}

		if ($this->aTag !== null && $this->aTag->getID() !== $v) {
			$this->aTag = null;
		}

	} 
	
	public function setTaggableModel($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->taggable_model !== $v) {
			$this->taggable_model = $v;
			$this->modifiedColumns[] = TaggingPeer::TAGGABLE_MODEL;
		}

	} 
	
	public function setTaggableId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->taggable_id !== $v) {
			$this->taggable_id = $v;
			$this->modifiedColumns[] = TaggingPeer::TAGGABLE_ID;
		}

	} 
	
	public function setUserId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_id !== $v) {
			$this->user_id = $v;
			$this->modifiedColumns[] = TaggingPeer::USER_ID;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->tag_id = $rs->getInt($startcol + 1);

			$this->taggable_model = $rs->getString($startcol + 2);

			$this->taggable_id = $rs->getInt($startcol + 3);

			$this->user_id = $rs->getInt($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Tagging object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BaseTagging:delete:pre') as $callable)
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
			$con = Propel::getConnection(TaggingPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			TaggingPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BaseTagging:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BaseTagging:save:pre') as $callable)
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
			$con = Propel::getConnection(TaggingPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BaseTagging:save:post') as $callable)
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


												
			if ($this->aTag !== null) {
				if ($this->aTag->isModified()) {
					$affectedRows += $this->aTag->save($con);
				}
				$this->setTag($this->aTag);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = TaggingPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setID($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += TaggingPeer::doUpdate($this, $con);
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


												
			if ($this->aTag !== null) {
				if (!$this->aTag->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aTag->getValidationFailures());
				}
			}


			if (($retval = TaggingPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TaggingPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getID();
				break;
			case 1:
				return $this->getTagId();
				break;
			case 2:
				return $this->getTaggableModel();
				break;
			case 3:
				return $this->getTaggableId();
				break;
			case 4:
				return $this->getUserId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TaggingPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getID(),
			$keys[1] => $this->getTagId(),
			$keys[2] => $this->getTaggableModel(),
			$keys[3] => $this->getTaggableId(),
			$keys[4] => $this->getUserId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = TaggingPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setID($value);
				break;
			case 1:
				$this->setTagId($value);
				break;
			case 2:
				$this->setTaggableModel($value);
				break;
			case 3:
				$this->setTaggableId($value);
				break;
			case 4:
				$this->setUserId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = TaggingPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setID($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTagId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTaggableModel($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTaggableId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setUserId($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(TaggingPeer::DATABASE_NAME);

		if ($this->isColumnModified(TaggingPeer::ID)) $criteria->add(TaggingPeer::ID, $this->id);
		if ($this->isColumnModified(TaggingPeer::TAG_ID)) $criteria->add(TaggingPeer::TAG_ID, $this->tag_id);
		if ($this->isColumnModified(TaggingPeer::TAGGABLE_MODEL)) $criteria->add(TaggingPeer::TAGGABLE_MODEL, $this->taggable_model);
		if ($this->isColumnModified(TaggingPeer::TAGGABLE_ID)) $criteria->add(TaggingPeer::TAGGABLE_ID, $this->taggable_id);
		if ($this->isColumnModified(TaggingPeer::USER_ID)) $criteria->add(TaggingPeer::USER_ID, $this->user_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(TaggingPeer::DATABASE_NAME);

		$criteria->add(TaggingPeer::ID, $this->id);

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

		$copyObj->setTagId($this->tag_id);

		$copyObj->setTaggableModel($this->taggable_model);

		$copyObj->setTaggableId($this->taggable_id);

		$copyObj->setUserId($this->user_id);


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
			self::$peer = new TaggingPeer();
		}
		return self::$peer;
	}

	
	public function setTag($v)
	{


		if ($v === null) {
			$this->setTagId(NULL);
		} else {
			$this->setTagId($v->getID());
		}


		$this->aTag = $v;
	}


	
	public function getTag($con = null)
	{
		if ($this->aTag === null && ($this->tag_id !== null)) {
						include_once 'plugins/deppPropelActAsTaggableBehaviorPlugin/lib/model/om/BaseTagPeer.php';

			$this->aTag = TagPeer::retrieveByPK($this->tag_id, $con);

			
		}
		return $this->aTag;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BaseTagging:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BaseTagging::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 