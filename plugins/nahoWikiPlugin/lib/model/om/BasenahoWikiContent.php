<?php


abstract class BasenahoWikiContent extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $content;


	
	protected $gz_content;

	
	protected $collnahoWikiRevisions;

	
	protected $lastnahoWikiRevisionCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getContent()
	{

		return $this->content;
	}

	
	public function getGzContent()
	{

		return $this->gz_content;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = nahoWikiContentPeer::ID;
		}

	} 
	
	public function setContent($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->content !== $v) {
			$this->content = $v;
			$this->modifiedColumns[] = nahoWikiContentPeer::CONTENT;
		}

	} 
	
	public function setGzContent($v)
	{

								if ($v instanceof Lob && $v === $this->gz_content) {
			$changed = $v->isModified();
		} else {
			$changed = ($this->gz_content !== $v);
		}
		if ($changed) {
			if ( !($v instanceof Lob) ) {
				$obj = new Blob();
				$obj->setContents($v);
			} else {
				$obj = $v;
			}
			$this->gz_content = $obj;
			$this->modifiedColumns[] = nahoWikiContentPeer::GZ_CONTENT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->content = $rs->getString($startcol + 1);

			$this->gz_content = $rs->getBlob($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating nahoWikiContent object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasenahoWikiContent:delete:pre') as $callable)
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
			$con = Propel::getConnection(nahoWikiContentPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			nahoWikiContentPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasenahoWikiContent:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasenahoWikiContent:save:pre') as $callable)
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
			$con = Propel::getConnection(nahoWikiContentPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasenahoWikiContent:save:post') as $callable)
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
					$pk = nahoWikiContentPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += nahoWikiContentPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collnahoWikiRevisions !== null) {
				foreach($this->collnahoWikiRevisions as $referrerFK) {
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


			if (($retval = nahoWikiContentPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collnahoWikiRevisions !== null) {
					foreach($this->collnahoWikiRevisions as $referrerFK) {
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
		$pos = nahoWikiContentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getContent();
				break;
			case 2:
				return $this->getGzContent();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = nahoWikiContentPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getContent(),
			$keys[2] => $this->getGzContent(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = nahoWikiContentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setContent($value);
				break;
			case 2:
				$this->setGzContent($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = nahoWikiContentPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setContent($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setGzContent($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(nahoWikiContentPeer::DATABASE_NAME);

		if ($this->isColumnModified(nahoWikiContentPeer::ID)) $criteria->add(nahoWikiContentPeer::ID, $this->id);
		if ($this->isColumnModified(nahoWikiContentPeer::CONTENT)) $criteria->add(nahoWikiContentPeer::CONTENT, $this->content);
		if ($this->isColumnModified(nahoWikiContentPeer::GZ_CONTENT)) $criteria->add(nahoWikiContentPeer::GZ_CONTENT, $this->gz_content);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(nahoWikiContentPeer::DATABASE_NAME);

		$criteria->add(nahoWikiContentPeer::ID, $this->id);

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

		$copyObj->setContent($this->content);

		$copyObj->setGzContent($this->gz_content);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getnahoWikiRevisions() as $relObj) {
				$copyObj->addnahoWikiRevision($relObj->copy($deepCopy));
			}

		} 

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
			self::$peer = new nahoWikiContentPeer();
		}
		return self::$peer;
	}

	
	public function initnahoWikiRevisions()
	{
		if ($this->collnahoWikiRevisions === null) {
			$this->collnahoWikiRevisions = array();
		}
	}

	
	public function getnahoWikiRevisions($criteria = null, $con = null)
	{
				include_once 'plugins/nahoWikiPlugin/lib/model/om/BasenahoWikiRevisionPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collnahoWikiRevisions === null) {
			if ($this->isNew()) {
			   $this->collnahoWikiRevisions = array();
			} else {

				$criteria->add(nahoWikiRevisionPeer::CONTENT_ID, $this->getId());

				nahoWikiRevisionPeer::addSelectColumns($criteria);
				$this->collnahoWikiRevisions = nahoWikiRevisionPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(nahoWikiRevisionPeer::CONTENT_ID, $this->getId());

				nahoWikiRevisionPeer::addSelectColumns($criteria);
				if (!isset($this->lastnahoWikiRevisionCriteria) || !$this->lastnahoWikiRevisionCriteria->equals($criteria)) {
					$this->collnahoWikiRevisions = nahoWikiRevisionPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastnahoWikiRevisionCriteria = $criteria;
		return $this->collnahoWikiRevisions;
	}

	
	public function countnahoWikiRevisions($criteria = null, $distinct = false, $con = null)
	{
				include_once 'plugins/nahoWikiPlugin/lib/model/om/BasenahoWikiRevisionPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(nahoWikiRevisionPeer::CONTENT_ID, $this->getId());

		return nahoWikiRevisionPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addnahoWikiRevision(nahoWikiRevision $l)
	{
		$this->collnahoWikiRevisions[] = $l;
		$l->setnahoWikiContent($this);
	}


	
	public function getnahoWikiRevisionsJoinnahoWikiPage($criteria = null, $con = null)
	{
				include_once 'plugins/nahoWikiPlugin/lib/model/om/BasenahoWikiRevisionPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collnahoWikiRevisions === null) {
			if ($this->isNew()) {
				$this->collnahoWikiRevisions = array();
			} else {

				$criteria->add(nahoWikiRevisionPeer::CONTENT_ID, $this->getId());

				$this->collnahoWikiRevisions = nahoWikiRevisionPeer::doSelectJoinnahoWikiPage($criteria, $con);
			}
		} else {
									
			$criteria->add(nahoWikiRevisionPeer::CONTENT_ID, $this->getId());

			if (!isset($this->lastnahoWikiRevisionCriteria) || !$this->lastnahoWikiRevisionCriteria->equals($criteria)) {
				$this->collnahoWikiRevisions = nahoWikiRevisionPeer::doSelectJoinnahoWikiPage($criteria, $con);
			}
		}
		$this->lastnahoWikiRevisionCriteria = $criteria;

		return $this->collnahoWikiRevisions;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasenahoWikiContent:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasenahoWikiContent::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 