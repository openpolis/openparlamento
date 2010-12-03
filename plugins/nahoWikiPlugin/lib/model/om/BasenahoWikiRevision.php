<?php


abstract class BasenahoWikiRevision extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $created_at;


	
	protected $page_id;


	
	protected $revision = 1;


	
	protected $user_name;


	
	protected $comment;


	
	protected $content_id;

	
	protected $anahoWikiPage;

	
	protected $anahoWikiContent;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
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

	
	public function getPageId()
	{

		return $this->page_id;
	}

	
	public function getRevision()
	{

		return $this->revision;
	}

	
	public function getUserName()
	{

		return $this->user_name;
	}

	
	public function getComment()
	{

		return $this->comment;
	}

	
	public function getContentId()
	{

		return $this->content_id;
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
			$this->modifiedColumns[] = nahoWikiRevisionPeer::CREATED_AT;
		}

	} 
	
	public function setPageId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->page_id !== $v) {
			$this->page_id = $v;
			$this->modifiedColumns[] = nahoWikiRevisionPeer::PAGE_ID;
		}

		if ($this->anahoWikiPage !== null && $this->anahoWikiPage->getId() !== $v) {
			$this->anahoWikiPage = null;
		}

	} 
	
	public function setRevision($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->revision !== $v || $v === 1) {
			$this->revision = $v;
			$this->modifiedColumns[] = nahoWikiRevisionPeer::REVISION;
		}

	} 
	
	public function setUserName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->user_name !== $v) {
			$this->user_name = $v;
			$this->modifiedColumns[] = nahoWikiRevisionPeer::USER_NAME;
		}

	} 
	
	public function setComment($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->comment !== $v) {
			$this->comment = $v;
			$this->modifiedColumns[] = nahoWikiRevisionPeer::COMMENT;
		}

	} 
	
	public function setContentId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->content_id !== $v) {
			$this->content_id = $v;
			$this->modifiedColumns[] = nahoWikiRevisionPeer::CONTENT_ID;
		}

		if ($this->anahoWikiContent !== null && $this->anahoWikiContent->getId() !== $v) {
			$this->anahoWikiContent = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->created_at = $rs->getTimestamp($startcol + 0, null);

			$this->page_id = $rs->getInt($startcol + 1);

			$this->revision = $rs->getInt($startcol + 2);

			$this->user_name = $rs->getString($startcol + 3);

			$this->comment = $rs->getString($startcol + 4);

			$this->content_id = $rs->getInt($startcol + 5);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating nahoWikiRevision object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasenahoWikiRevision:delete:pre') as $callable)
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
			$con = Propel::getConnection(nahoWikiRevisionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			nahoWikiRevisionPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasenahoWikiRevision:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasenahoWikiRevision:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(nahoWikiRevisionPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(nahoWikiRevisionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasenahoWikiRevision:save:post') as $callable)
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


												
			if ($this->anahoWikiPage !== null) {
				if ($this->anahoWikiPage->isModified()) {
					$affectedRows += $this->anahoWikiPage->save($con);
				}
				$this->setnahoWikiPage($this->anahoWikiPage);
			}

			if ($this->anahoWikiContent !== null) {
				if ($this->anahoWikiContent->isModified()) {
					$affectedRows += $this->anahoWikiContent->save($con);
				}
				$this->setnahoWikiContent($this->anahoWikiContent);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = nahoWikiRevisionPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += nahoWikiRevisionPeer::doUpdate($this, $con);
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


												
			if ($this->anahoWikiPage !== null) {
				if (!$this->anahoWikiPage->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->anahoWikiPage->getValidationFailures());
				}
			}

			if ($this->anahoWikiContent !== null) {
				if (!$this->anahoWikiContent->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->anahoWikiContent->getValidationFailures());
				}
			}


			if (($retval = nahoWikiRevisionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = nahoWikiRevisionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getCreatedAt();
				break;
			case 1:
				return $this->getPageId();
				break;
			case 2:
				return $this->getRevision();
				break;
			case 3:
				return $this->getUserName();
				break;
			case 4:
				return $this->getComment();
				break;
			case 5:
				return $this->getContentId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = nahoWikiRevisionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCreatedAt(),
			$keys[1] => $this->getPageId(),
			$keys[2] => $this->getRevision(),
			$keys[3] => $this->getUserName(),
			$keys[4] => $this->getComment(),
			$keys[5] => $this->getContentId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = nahoWikiRevisionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setCreatedAt($value);
				break;
			case 1:
				$this->setPageId($value);
				break;
			case 2:
				$this->setRevision($value);
				break;
			case 3:
				$this->setUserName($value);
				break;
			case 4:
				$this->setComment($value);
				break;
			case 5:
				$this->setContentId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = nahoWikiRevisionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCreatedAt($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPageId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setRevision($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setUserName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setComment($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setContentId($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(nahoWikiRevisionPeer::DATABASE_NAME);

		if ($this->isColumnModified(nahoWikiRevisionPeer::CREATED_AT)) $criteria->add(nahoWikiRevisionPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(nahoWikiRevisionPeer::PAGE_ID)) $criteria->add(nahoWikiRevisionPeer::PAGE_ID, $this->page_id);
		if ($this->isColumnModified(nahoWikiRevisionPeer::REVISION)) $criteria->add(nahoWikiRevisionPeer::REVISION, $this->revision);
		if ($this->isColumnModified(nahoWikiRevisionPeer::USER_NAME)) $criteria->add(nahoWikiRevisionPeer::USER_NAME, $this->user_name);
		if ($this->isColumnModified(nahoWikiRevisionPeer::COMMENT)) $criteria->add(nahoWikiRevisionPeer::COMMENT, $this->comment);
		if ($this->isColumnModified(nahoWikiRevisionPeer::CONTENT_ID)) $criteria->add(nahoWikiRevisionPeer::CONTENT_ID, $this->content_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(nahoWikiRevisionPeer::DATABASE_NAME);

		$criteria->add(nahoWikiRevisionPeer::PAGE_ID, $this->page_id);
		$criteria->add(nahoWikiRevisionPeer::REVISION, $this->revision);
		$criteria->add(nahoWikiRevisionPeer::CONTENT_ID, $this->content_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getPageId();

		$pks[1] = $this->getRevision();

		$pks[2] = $this->getContentId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setPageId($keys[0]);

		$this->setRevision($keys[1]);

		$this->setContentId($keys[2]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setUserName($this->user_name);

		$copyObj->setComment($this->comment);


		$copyObj->setNew(true);

		$copyObj->setPageId(NULL); 
		$copyObj->setRevision('1'); 
		$copyObj->setContentId(NULL); 
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
			self::$peer = new nahoWikiRevisionPeer();
		}
		return self::$peer;
	}

	
	public function setnahoWikiPage($v)
	{


		if ($v === null) {
			$this->setPageId(NULL);
		} else {
			$this->setPageId($v->getId());
		}


		$this->anahoWikiPage = $v;
	}


	
	public function getnahoWikiPage($con = null)
	{
		if ($this->anahoWikiPage === null && ($this->page_id !== null)) {
						include_once 'plugins/nahoWikiPlugin/lib/model/om/BasenahoWikiPagePeer.php';

			$this->anahoWikiPage = nahoWikiPagePeer::retrieveByPK($this->page_id, $con);

			
		}
		return $this->anahoWikiPage;
	}

	
	public function setnahoWikiContent($v)
	{


		if ($v === null) {
			$this->setContentId(NULL);
		} else {
			$this->setContentId($v->getId());
		}


		$this->anahoWikiContent = $v;
	}


	
	public function getnahoWikiContent($con = null)
	{
		if ($this->anahoWikiContent === null && ($this->content_id !== null)) {
						include_once 'plugins/nahoWikiPlugin/lib/model/om/BasenahoWikiContentPeer.php';

			$this->anahoWikiContent = nahoWikiContentPeer::retrieveByPK($this->content_id, $con);

			
		}
		return $this->anahoWikiContent;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasenahoWikiRevision:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasenahoWikiRevision::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 