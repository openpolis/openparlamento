<?php


abstract class BasesfSimpleBlogTag extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $sf_blog_post_id;


	
	protected $tag;


	
	protected $created_at;

	
	protected $asfSimpleBlogPost;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getSfBlogPostId()
	{

		return $this->sf_blog_post_id;
	}

	
	public function getTag()
	{

		return $this->tag;
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

	
	public function setSfBlogPostId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->sf_blog_post_id !== $v) {
			$this->sf_blog_post_id = $v;
			$this->modifiedColumns[] = sfSimpleBlogTagPeer::SF_BLOG_POST_ID;
		}

		if ($this->asfSimpleBlogPost !== null && $this->asfSimpleBlogPost->getId() !== $v) {
			$this->asfSimpleBlogPost = null;
		}

	} 
	
	public function setTag($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->tag !== $v) {
			$this->tag = $v;
			$this->modifiedColumns[] = sfSimpleBlogTagPeer::TAG;
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
			$this->modifiedColumns[] = sfSimpleBlogTagPeer::CREATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->sf_blog_post_id = $rs->getInt($startcol + 0);

			$this->tag = $rs->getString($startcol + 1);

			$this->created_at = $rs->getTimestamp($startcol + 2, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfSimpleBlogTag object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfSimpleBlogTag:delete:pre') as $callable)
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
			$con = Propel::getConnection(sfSimpleBlogTagPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfSimpleBlogTagPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfSimpleBlogTag:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfSimpleBlogTag:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(sfSimpleBlogTagPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfSimpleBlogTagPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfSimpleBlogTag:save:post') as $callable)
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


												
			if ($this->asfSimpleBlogPost !== null) {
				if ($this->asfSimpleBlogPost->isModified()) {
					$affectedRows += $this->asfSimpleBlogPost->save($con);
				}
				$this->setsfSimpleBlogPost($this->asfSimpleBlogPost);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfSimpleBlogTagPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += sfSimpleBlogTagPeer::doUpdate($this, $con);
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


												
			if ($this->asfSimpleBlogPost !== null) {
				if (!$this->asfSimpleBlogPost->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->asfSimpleBlogPost->getValidationFailures());
				}
			}


			if (($retval = sfSimpleBlogTagPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfSimpleBlogTagPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getSfBlogPostId();
				break;
			case 1:
				return $this->getTag();
				break;
			case 2:
				return $this->getCreatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfSimpleBlogTagPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getSfBlogPostId(),
			$keys[1] => $this->getTag(),
			$keys[2] => $this->getCreatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfSimpleBlogTagPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setSfBlogPostId($value);
				break;
			case 1:
				$this->setTag($value);
				break;
			case 2:
				$this->setCreatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfSimpleBlogTagPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setSfBlogPostId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTag($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setCreatedAt($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfSimpleBlogTagPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfSimpleBlogTagPeer::SF_BLOG_POST_ID)) $criteria->add(sfSimpleBlogTagPeer::SF_BLOG_POST_ID, $this->sf_blog_post_id);
		if ($this->isColumnModified(sfSimpleBlogTagPeer::TAG)) $criteria->add(sfSimpleBlogTagPeer::TAG, $this->tag);
		if ($this->isColumnModified(sfSimpleBlogTagPeer::CREATED_AT)) $criteria->add(sfSimpleBlogTagPeer::CREATED_AT, $this->created_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfSimpleBlogTagPeer::DATABASE_NAME);

		$criteria->add(sfSimpleBlogTagPeer::SF_BLOG_POST_ID, $this->sf_blog_post_id);
		$criteria->add(sfSimpleBlogTagPeer::TAG, $this->tag);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getSfBlogPostId();

		$pks[1] = $this->getTag();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setSfBlogPostId($keys[0]);

		$this->setTag($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setCreatedAt($this->created_at);


		$copyObj->setNew(true);

		$copyObj->setSfBlogPostId(NULL); 
		$copyObj->setTag(NULL); 
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
			self::$peer = new sfSimpleBlogTagPeer();
		}
		return self::$peer;
	}

	
	public function setsfSimpleBlogPost($v)
	{


		if ($v === null) {
			$this->setSfBlogPostId(NULL);
		} else {
			$this->setSfBlogPostId($v->getId());
		}


		$this->asfSimpleBlogPost = $v;
	}


	
	public function getsfSimpleBlogPost($con = null)
	{
		if ($this->asfSimpleBlogPost === null && ($this->sf_blog_post_id !== null)) {
						include_once 'plugins/sfSimpleBlogPlugin/lib/model/om/BasesfSimpleBlogPostPeer.php';

			$this->asfSimpleBlogPost = sfSimpleBlogPostPeer::retrieveByPK($this->sf_blog_post_id, $con);

			
		}
		return $this->asfSimpleBlogPost;
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfSimpleBlogTag:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfSimpleBlogTag::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 