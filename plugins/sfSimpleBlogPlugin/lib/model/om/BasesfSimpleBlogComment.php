<?php


abstract class BasesfSimpleBlogComment extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $sf_blog_post_id;


	
	protected $author_name;


	
	protected $author_email;


	
	protected $author_url;


	
	protected $content;


	
	protected $is_moderated = false;


	
	protected $created_at;

	
	protected $asfSimpleBlogPost;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getSfBlogPostId()
	{

		return $this->sf_blog_post_id;
	}

	
	public function getAuthorName()
	{

		return $this->author_name;
	}

	
	public function getAuthorEmail()
	{

		return $this->author_email;
	}

	
	public function getAuthorUrl()
	{

		return $this->author_url;
	}

	
	public function getContent()
	{

		return $this->content;
	}

	
	public function getIsModerated()
	{

		return $this->is_moderated;
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

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = sfSimpleBlogCommentPeer::ID;
		}

	} 
	
	public function setSfBlogPostId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->sf_blog_post_id !== $v) {
			$this->sf_blog_post_id = $v;
			$this->modifiedColumns[] = sfSimpleBlogCommentPeer::SF_BLOG_POST_ID;
		}

		if ($this->asfSimpleBlogPost !== null && $this->asfSimpleBlogPost->getId() !== $v) {
			$this->asfSimpleBlogPost = null;
		}

	} 
	
	public function setAuthorName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->author_name !== $v) {
			$this->author_name = $v;
			$this->modifiedColumns[] = sfSimpleBlogCommentPeer::AUTHOR_NAME;
		}

	} 
	
	public function setAuthorEmail($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->author_email !== $v) {
			$this->author_email = $v;
			$this->modifiedColumns[] = sfSimpleBlogCommentPeer::AUTHOR_EMAIL;
		}

	} 
	
	public function setAuthorUrl($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->author_url !== $v) {
			$this->author_url = $v;
			$this->modifiedColumns[] = sfSimpleBlogCommentPeer::AUTHOR_URL;
		}

	} 
	
	public function setContent($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->content !== $v) {
			$this->content = $v;
			$this->modifiedColumns[] = sfSimpleBlogCommentPeer::CONTENT;
		}

	} 
	
	public function setIsModerated($v)
	{

		if ($this->is_moderated !== $v || $v === false) {
			$this->is_moderated = $v;
			$this->modifiedColumns[] = sfSimpleBlogCommentPeer::IS_MODERATED;
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
			$this->modifiedColumns[] = sfSimpleBlogCommentPeer::CREATED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->sf_blog_post_id = $rs->getInt($startcol + 1);

			$this->author_name = $rs->getString($startcol + 2);

			$this->author_email = $rs->getString($startcol + 3);

			$this->author_url = $rs->getString($startcol + 4);

			$this->content = $rs->getString($startcol + 5);

			$this->is_moderated = $rs->getBoolean($startcol + 6);

			$this->created_at = $rs->getTimestamp($startcol + 7, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfSimpleBlogComment object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfSimpleBlogComment:delete:pre') as $callable)
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
			$con = Propel::getConnection(sfSimpleBlogCommentPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfSimpleBlogCommentPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfSimpleBlogComment:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfSimpleBlogComment:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(sfSimpleBlogCommentPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfSimpleBlogCommentPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfSimpleBlogComment:save:post') as $callable)
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
					$pk = sfSimpleBlogCommentPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += sfSimpleBlogCommentPeer::doUpdate($this, $con);
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


			if (($retval = sfSimpleBlogCommentPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfSimpleBlogCommentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getSfBlogPostId();
				break;
			case 2:
				return $this->getAuthorName();
				break;
			case 3:
				return $this->getAuthorEmail();
				break;
			case 4:
				return $this->getAuthorUrl();
				break;
			case 5:
				return $this->getContent();
				break;
			case 6:
				return $this->getIsModerated();
				break;
			case 7:
				return $this->getCreatedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfSimpleBlogCommentPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getSfBlogPostId(),
			$keys[2] => $this->getAuthorName(),
			$keys[3] => $this->getAuthorEmail(),
			$keys[4] => $this->getAuthorUrl(),
			$keys[5] => $this->getContent(),
			$keys[6] => $this->getIsModerated(),
			$keys[7] => $this->getCreatedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfSimpleBlogCommentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setSfBlogPostId($value);
				break;
			case 2:
				$this->setAuthorName($value);
				break;
			case 3:
				$this->setAuthorEmail($value);
				break;
			case 4:
				$this->setAuthorUrl($value);
				break;
			case 5:
				$this->setContent($value);
				break;
			case 6:
				$this->setIsModerated($value);
				break;
			case 7:
				$this->setCreatedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfSimpleBlogCommentPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setSfBlogPostId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setAuthorName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setAuthorEmail($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setAuthorUrl($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setContent($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIsModerated($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setCreatedAt($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfSimpleBlogCommentPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfSimpleBlogCommentPeer::ID)) $criteria->add(sfSimpleBlogCommentPeer::ID, $this->id);
		if ($this->isColumnModified(sfSimpleBlogCommentPeer::SF_BLOG_POST_ID)) $criteria->add(sfSimpleBlogCommentPeer::SF_BLOG_POST_ID, $this->sf_blog_post_id);
		if ($this->isColumnModified(sfSimpleBlogCommentPeer::AUTHOR_NAME)) $criteria->add(sfSimpleBlogCommentPeer::AUTHOR_NAME, $this->author_name);
		if ($this->isColumnModified(sfSimpleBlogCommentPeer::AUTHOR_EMAIL)) $criteria->add(sfSimpleBlogCommentPeer::AUTHOR_EMAIL, $this->author_email);
		if ($this->isColumnModified(sfSimpleBlogCommentPeer::AUTHOR_URL)) $criteria->add(sfSimpleBlogCommentPeer::AUTHOR_URL, $this->author_url);
		if ($this->isColumnModified(sfSimpleBlogCommentPeer::CONTENT)) $criteria->add(sfSimpleBlogCommentPeer::CONTENT, $this->content);
		if ($this->isColumnModified(sfSimpleBlogCommentPeer::IS_MODERATED)) $criteria->add(sfSimpleBlogCommentPeer::IS_MODERATED, $this->is_moderated);
		if ($this->isColumnModified(sfSimpleBlogCommentPeer::CREATED_AT)) $criteria->add(sfSimpleBlogCommentPeer::CREATED_AT, $this->created_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfSimpleBlogCommentPeer::DATABASE_NAME);

		$criteria->add(sfSimpleBlogCommentPeer::ID, $this->id);

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

		$copyObj->setSfBlogPostId($this->sf_blog_post_id);

		$copyObj->setAuthorName($this->author_name);

		$copyObj->setAuthorEmail($this->author_email);

		$copyObj->setAuthorUrl($this->author_url);

		$copyObj->setContent($this->content);

		$copyObj->setIsModerated($this->is_moderated);

		$copyObj->setCreatedAt($this->created_at);


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
			self::$peer = new sfSimpleBlogCommentPeer();
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
    if (!$callable = sfMixer::getCallable('BasesfSimpleBlogComment:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfSimpleBlogComment::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 