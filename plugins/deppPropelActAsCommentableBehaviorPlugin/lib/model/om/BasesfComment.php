<?php


abstract class BasesfComment extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $commentable_model;


	
	protected $commentable_id;


	
	protected $comment_namespace;


	
	protected $title;


	
	protected $text;


	
	protected $author_id;


	
	protected $author_name;


	
	protected $author_email;


	
	protected $author_website;


	
	protected $created_at;


	
	protected $is_public = 1;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getCommentableModel()
	{

		return $this->commentable_model;
	}

	
	public function getCommentableId()
	{

		return $this->commentable_id;
	}

	
	public function getCommentNamespace()
	{

		return $this->comment_namespace;
	}

	
	public function getTitle()
	{

		return $this->title;
	}

	
	public function getText()
	{

		return $this->text;
	}

	
	public function getAuthorId()
	{

		return $this->author_id;
	}

	
	public function getAuthorName()
	{

		return $this->author_name;
	}

	
	public function getAuthorEmail()
	{

		return $this->author_email;
	}

	
	public function getAuthorWebsite()
	{

		return $this->author_website;
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
			$this->modifiedColumns[] = sfCommentPeer::ID;
		}

	} 
	
	public function setCommentableModel($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->commentable_model !== $v) {
			$this->commentable_model = $v;
			$this->modifiedColumns[] = sfCommentPeer::COMMENTABLE_MODEL;
		}

	} 
	
	public function setCommentableId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->commentable_id !== $v) {
			$this->commentable_id = $v;
			$this->modifiedColumns[] = sfCommentPeer::COMMENTABLE_ID;
		}

	} 
	
	public function setCommentNamespace($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->comment_namespace !== $v) {
			$this->comment_namespace = $v;
			$this->modifiedColumns[] = sfCommentPeer::COMMENT_NAMESPACE;
		}

	} 
	
	public function setTitle($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = sfCommentPeer::TITLE;
		}

	} 
	
	public function setText($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->text !== $v) {
			$this->text = $v;
			$this->modifiedColumns[] = sfCommentPeer::TEXT;
		}

	} 
	
	public function setAuthorId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->author_id !== $v) {
			$this->author_id = $v;
			$this->modifiedColumns[] = sfCommentPeer::AUTHOR_ID;
		}

	} 
	
	public function setAuthorName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->author_name !== $v) {
			$this->author_name = $v;
			$this->modifiedColumns[] = sfCommentPeer::AUTHOR_NAME;
		}

	} 
	
	public function setAuthorEmail($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->author_email !== $v) {
			$this->author_email = $v;
			$this->modifiedColumns[] = sfCommentPeer::AUTHOR_EMAIL;
		}

	} 
	
	public function setAuthorWebsite($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->author_website !== $v) {
			$this->author_website = $v;
			$this->modifiedColumns[] = sfCommentPeer::AUTHOR_WEBSITE;
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
			$this->modifiedColumns[] = sfCommentPeer::CREATED_AT;
		}

	} 
	
	public function setIsPublic($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->is_public !== $v || $v === 1) {
			$this->is_public = $v;
			$this->modifiedColumns[] = sfCommentPeer::IS_PUBLIC;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->commentable_model = $rs->getString($startcol + 1);

			$this->commentable_id = $rs->getInt($startcol + 2);

			$this->comment_namespace = $rs->getString($startcol + 3);

			$this->title = $rs->getString($startcol + 4);

			$this->text = $rs->getString($startcol + 5);

			$this->author_id = $rs->getInt($startcol + 6);

			$this->author_name = $rs->getString($startcol + 7);

			$this->author_email = $rs->getString($startcol + 8);

			$this->author_website = $rs->getString($startcol + 9);

			$this->created_at = $rs->getTimestamp($startcol + 10, null);

			$this->is_public = $rs->getInt($startcol + 11);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 12; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfComment object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfComment:delete:pre') as $callable)
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
			$con = Propel::getConnection(sfCommentPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfCommentPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfComment:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfComment:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(sfCommentPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfCommentPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfComment:save:post') as $callable)
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
					$pk = sfCommentPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += sfCommentPeer::doUpdate($this, $con);
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


			if (($retval = sfCommentPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfCommentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getCommentableModel();
				break;
			case 2:
				return $this->getCommentableId();
				break;
			case 3:
				return $this->getCommentNamespace();
				break;
			case 4:
				return $this->getTitle();
				break;
			case 5:
				return $this->getText();
				break;
			case 6:
				return $this->getAuthorId();
				break;
			case 7:
				return $this->getAuthorName();
				break;
			case 8:
				return $this->getAuthorEmail();
				break;
			case 9:
				return $this->getAuthorWebsite();
				break;
			case 10:
				return $this->getCreatedAt();
				break;
			case 11:
				return $this->getIsPublic();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfCommentPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCommentableModel(),
			$keys[2] => $this->getCommentableId(),
			$keys[3] => $this->getCommentNamespace(),
			$keys[4] => $this->getTitle(),
			$keys[5] => $this->getText(),
			$keys[6] => $this->getAuthorId(),
			$keys[7] => $this->getAuthorName(),
			$keys[8] => $this->getAuthorEmail(),
			$keys[9] => $this->getAuthorWebsite(),
			$keys[10] => $this->getCreatedAt(),
			$keys[11] => $this->getIsPublic(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfCommentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setCommentableModel($value);
				break;
			case 2:
				$this->setCommentableId($value);
				break;
			case 3:
				$this->setCommentNamespace($value);
				break;
			case 4:
				$this->setTitle($value);
				break;
			case 5:
				$this->setText($value);
				break;
			case 6:
				$this->setAuthorId($value);
				break;
			case 7:
				$this->setAuthorName($value);
				break;
			case 8:
				$this->setAuthorEmail($value);
				break;
			case 9:
				$this->setAuthorWebsite($value);
				break;
			case 10:
				$this->setCreatedAt($value);
				break;
			case 11:
				$this->setIsPublic($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfCommentPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCommentableModel($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setCommentableId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCommentNamespace($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setTitle($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setText($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setAuthorId($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setAuthorName($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setAuthorEmail($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setAuthorWebsite($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setCreatedAt($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setIsPublic($arr[$keys[11]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfCommentPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfCommentPeer::ID)) $criteria->add(sfCommentPeer::ID, $this->id);
		if ($this->isColumnModified(sfCommentPeer::COMMENTABLE_MODEL)) $criteria->add(sfCommentPeer::COMMENTABLE_MODEL, $this->commentable_model);
		if ($this->isColumnModified(sfCommentPeer::COMMENTABLE_ID)) $criteria->add(sfCommentPeer::COMMENTABLE_ID, $this->commentable_id);
		if ($this->isColumnModified(sfCommentPeer::COMMENT_NAMESPACE)) $criteria->add(sfCommentPeer::COMMENT_NAMESPACE, $this->comment_namespace);
		if ($this->isColumnModified(sfCommentPeer::TITLE)) $criteria->add(sfCommentPeer::TITLE, $this->title);
		if ($this->isColumnModified(sfCommentPeer::TEXT)) $criteria->add(sfCommentPeer::TEXT, $this->text);
		if ($this->isColumnModified(sfCommentPeer::AUTHOR_ID)) $criteria->add(sfCommentPeer::AUTHOR_ID, $this->author_id);
		if ($this->isColumnModified(sfCommentPeer::AUTHOR_NAME)) $criteria->add(sfCommentPeer::AUTHOR_NAME, $this->author_name);
		if ($this->isColumnModified(sfCommentPeer::AUTHOR_EMAIL)) $criteria->add(sfCommentPeer::AUTHOR_EMAIL, $this->author_email);
		if ($this->isColumnModified(sfCommentPeer::AUTHOR_WEBSITE)) $criteria->add(sfCommentPeer::AUTHOR_WEBSITE, $this->author_website);
		if ($this->isColumnModified(sfCommentPeer::CREATED_AT)) $criteria->add(sfCommentPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(sfCommentPeer::IS_PUBLIC)) $criteria->add(sfCommentPeer::IS_PUBLIC, $this->is_public);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfCommentPeer::DATABASE_NAME);

		$criteria->add(sfCommentPeer::ID, $this->id);

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

		$copyObj->setCommentableModel($this->commentable_model);

		$copyObj->setCommentableId($this->commentable_id);

		$copyObj->setCommentNamespace($this->comment_namespace);

		$copyObj->setTitle($this->title);

		$copyObj->setText($this->text);

		$copyObj->setAuthorId($this->author_id);

		$copyObj->setAuthorName($this->author_name);

		$copyObj->setAuthorEmail($this->author_email);

		$copyObj->setAuthorWebsite($this->author_website);

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
			self::$peer = new sfCommentPeer();
		}
		return self::$peer;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfComment:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfComment::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 