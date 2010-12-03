<?php


abstract class BasesfEmendComment extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $url;


	
	protected $selection;


	
	protected $title;


	
	protected $body;


	
	protected $author_id;


	
	protected $author_name;


	
	protected $created_at;


	
	protected $is_public = 1;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getUrl()
	{

		return $this->url;
	}

	
	public function getSelection()
	{

		return $this->selection;
	}

	
	public function getTitle()
	{

		return $this->title;
	}

	
	public function getBody()
	{

		return $this->body;
	}

	
	public function getAuthorId()
	{

		return $this->author_id;
	}

	
	public function getAuthorName()
	{

		return $this->author_name;
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

	
	public function getIsPublic()
	{

		return $this->is_public;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = sfEmendCommentPeer::ID;
		}

	} 
	
	public function setUrl($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->url !== $v) {
			$this->url = $v;
			$this->modifiedColumns[] = sfEmendCommentPeer::URL;
		}

	} 
	
	public function setSelection($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->selection !== $v) {
			$this->selection = $v;
			$this->modifiedColumns[] = sfEmendCommentPeer::SELECTION;
		}

	} 
	
	public function setTitle($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = sfEmendCommentPeer::TITLE;
		}

	} 
	
	public function setBody($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->body !== $v) {
			$this->body = $v;
			$this->modifiedColumns[] = sfEmendCommentPeer::BODY;
		}

	} 
	
	public function setAuthorId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->author_id !== $v) {
			$this->author_id = $v;
			$this->modifiedColumns[] = sfEmendCommentPeer::AUTHOR_ID;
		}

	} 
	
	public function setAuthorName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->author_name !== $v) {
			$this->author_name = $v;
			$this->modifiedColumns[] = sfEmendCommentPeer::AUTHOR_NAME;
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
			$this->modifiedColumns[] = sfEmendCommentPeer::CREATED_AT;
		}

	} 
	
	public function setIsPublic($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->is_public !== $v || $v === 1) {
			$this->is_public = $v;
			$this->modifiedColumns[] = sfEmendCommentPeer::IS_PUBLIC;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->url = $rs->getString($startcol + 1);

			$this->selection = $rs->getString($startcol + 2);

			$this->title = $rs->getString($startcol + 3);

			$this->body = $rs->getString($startcol + 4);

			$this->author_id = $rs->getInt($startcol + 5);

			$this->author_name = $rs->getString($startcol + 6);

			$this->created_at = $rs->getTimestamp($startcol + 7, null);

			$this->is_public = $rs->getInt($startcol + 8);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 9; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfEmendComment object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfEmendComment:delete:pre') as $callable)
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
			$con = Propel::getConnection(sfEmendCommentPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfEmendCommentPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfEmendComment:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfEmendComment:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(sfEmendCommentPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfEmendCommentPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfEmendComment:save:post') as $callable)
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
					$pk = sfEmendCommentPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += sfEmendCommentPeer::doUpdate($this, $con);
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


			if (($retval = sfEmendCommentPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfEmendCommentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getUrl();
				break;
			case 2:
				return $this->getSelection();
				break;
			case 3:
				return $this->getTitle();
				break;
			case 4:
				return $this->getBody();
				break;
			case 5:
				return $this->getAuthorId();
				break;
			case 6:
				return $this->getAuthorName();
				break;
			case 7:
				return $this->getCreatedAt();
				break;
			case 8:
				return $this->getIsPublic();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfEmendCommentPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getUrl(),
			$keys[2] => $this->getSelection(),
			$keys[3] => $this->getTitle(),
			$keys[4] => $this->getBody(),
			$keys[5] => $this->getAuthorId(),
			$keys[6] => $this->getAuthorName(),
			$keys[7] => $this->getCreatedAt(),
			$keys[8] => $this->getIsPublic(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfEmendCommentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setUrl($value);
				break;
			case 2:
				$this->setSelection($value);
				break;
			case 3:
				$this->setTitle($value);
				break;
			case 4:
				$this->setBody($value);
				break;
			case 5:
				$this->setAuthorId($value);
				break;
			case 6:
				$this->setAuthorName($value);
				break;
			case 7:
				$this->setCreatedAt($value);
				break;
			case 8:
				$this->setIsPublic($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfEmendCommentPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setUrl($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSelection($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTitle($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setBody($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setAuthorId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setAuthorName($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCreatedAt($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsPublic($arr[$keys[8]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfEmendCommentPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfEmendCommentPeer::ID)) $criteria->add(sfEmendCommentPeer::ID, $this->id);
		if ($this->isColumnModified(sfEmendCommentPeer::URL)) $criteria->add(sfEmendCommentPeer::URL, $this->url);
		if ($this->isColumnModified(sfEmendCommentPeer::SELECTION)) $criteria->add(sfEmendCommentPeer::SELECTION, $this->selection);
		if ($this->isColumnModified(sfEmendCommentPeer::TITLE)) $criteria->add(sfEmendCommentPeer::TITLE, $this->title);
		if ($this->isColumnModified(sfEmendCommentPeer::BODY)) $criteria->add(sfEmendCommentPeer::BODY, $this->body);
		if ($this->isColumnModified(sfEmendCommentPeer::AUTHOR_ID)) $criteria->add(sfEmendCommentPeer::AUTHOR_ID, $this->author_id);
		if ($this->isColumnModified(sfEmendCommentPeer::AUTHOR_NAME)) $criteria->add(sfEmendCommentPeer::AUTHOR_NAME, $this->author_name);
		if ($this->isColumnModified(sfEmendCommentPeer::CREATED_AT)) $criteria->add(sfEmendCommentPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(sfEmendCommentPeer::IS_PUBLIC)) $criteria->add(sfEmendCommentPeer::IS_PUBLIC, $this->is_public);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfEmendCommentPeer::DATABASE_NAME);

		$criteria->add(sfEmendCommentPeer::ID, $this->id);

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

		$copyObj->setUrl($this->url);

		$copyObj->setSelection($this->selection);

		$copyObj->setTitle($this->title);

		$copyObj->setBody($this->body);

		$copyObj->setAuthorId($this->author_id);

		$copyObj->setAuthorName($this->author_name);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setIsPublic($this->is_public);


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
			self::$peer = new sfEmendCommentPeer();
		}
		return self::$peer;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfEmendComment:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfEmendComment::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 