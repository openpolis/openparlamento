<?php


abstract class BasesfSimpleBlogPost extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $author_id;


	
	protected $title;


	
	protected $stripped_title;


	
	protected $extract;


	
	protected $content;


	
	protected $is_published = false;


	
	protected $allow_comments = true;


	
	protected $created_at;


	
	protected $published_at;

	
	protected $aOppUser;

	
	protected $collsfSimpleBlogComments;

	
	protected $lastsfSimpleBlogCommentCriteria = null;

	
	protected $collsfSimpleBlogTags;

	
	protected $lastsfSimpleBlogTagCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getAuthorId()
	{

		return $this->author_id;
	}

	
	public function getTitle()
	{

		return $this->title;
	}

	
	public function getStrippedTitle()
	{

		return $this->stripped_title;
	}

	
	public function getExtract()
	{

		return $this->extract;
	}

	
	public function getContent()
	{

		return $this->content;
	}

	
	public function getIsPublished()
	{

		return $this->is_published;
	}

	
	public function getAllowComments()
	{

		return $this->allow_comments;
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

	
	public function getPublishedAt($format = 'Y-m-d')
	{

		if ($this->published_at === null || $this->published_at === '') {
			return null;
		} elseif (!is_int($this->published_at)) {
						$ts = strtotime($this->published_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [published_at] as date/time value: " . var_export($this->published_at, true));
			}
		} else {
			$ts = $this->published_at;
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
			$this->modifiedColumns[] = sfSimpleBlogPostPeer::ID;
		}

	} 
	
	public function setAuthorId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->author_id !== $v) {
			$this->author_id = $v;
			$this->modifiedColumns[] = sfSimpleBlogPostPeer::AUTHOR_ID;
		}

		if ($this->aOppUser !== null && $this->aOppUser->getId() !== $v) {
			$this->aOppUser = null;
		}

	} 
	
	public function setTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = sfSimpleBlogPostPeer::TITLE;
		}

	} 
	
	public function setStrippedTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->stripped_title !== $v) {
			$this->stripped_title = $v;
			$this->modifiedColumns[] = sfSimpleBlogPostPeer::STRIPPED_TITLE;
		}

	} 
	
	public function setExtract($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->extract !== $v) {
			$this->extract = $v;
			$this->modifiedColumns[] = sfSimpleBlogPostPeer::EXTRACT;
		}

	} 
	
	public function setContent($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->content !== $v) {
			$this->content = $v;
			$this->modifiedColumns[] = sfSimpleBlogPostPeer::CONTENT;
		}

	} 
	
	public function setIsPublished($v)
	{

		if ($this->is_published !== $v || $v === false) {
			$this->is_published = $v;
			$this->modifiedColumns[] = sfSimpleBlogPostPeer::IS_PUBLISHED;
		}

	} 
	
	public function setAllowComments($v)
	{

		if ($this->allow_comments !== $v || $v === true) {
			$this->allow_comments = $v;
			$this->modifiedColumns[] = sfSimpleBlogPostPeer::ALLOW_COMMENTS;
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
			$this->modifiedColumns[] = sfSimpleBlogPostPeer::CREATED_AT;
		}

	} 
	
	public function setPublishedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [published_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->published_at !== $ts) {
			$this->published_at = $ts;
			$this->modifiedColumns[] = sfSimpleBlogPostPeer::PUBLISHED_AT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->author_id = $rs->getInt($startcol + 1);

			$this->title = $rs->getString($startcol + 2);

			$this->stripped_title = $rs->getString($startcol + 3);

			$this->extract = $rs->getString($startcol + 4);

			$this->content = $rs->getString($startcol + 5);

			$this->is_published = $rs->getBoolean($startcol + 6);

			$this->allow_comments = $rs->getBoolean($startcol + 7);

			$this->created_at = $rs->getTimestamp($startcol + 8, null);

			$this->published_at = $rs->getDate($startcol + 9, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 10; 
		} catch (Exception $e) {
			throw new PropelException("Error populating sfSimpleBlogPost object", $e);
		}
	}

	
	public function delete($con = null)
	{

    foreach (sfMixer::getCallables('BasesfSimpleBlogPost:delete:pre') as $callable)
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
			$con = Propel::getConnection(sfSimpleBlogPostPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			sfSimpleBlogPostPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	

    foreach (sfMixer::getCallables('BasesfSimpleBlogPost:delete:post') as $callable)
    {
      call_user_func($callable, $this, $con);
    }

  }
	
	public function save($con = null)
	{

    foreach (sfMixer::getCallables('BasesfSimpleBlogPost:save:pre') as $callable)
    {
      $affectedRows = call_user_func($callable, $this, $con);
      if (is_int($affectedRows))
      {
        return $affectedRows;
      }
    }


    if ($this->isNew() && !$this->isColumnModified(sfSimpleBlogPostPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(sfSimpleBlogPostPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
    foreach (sfMixer::getCallables('BasesfSimpleBlogPost:save:post') as $callable)
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


												
			if ($this->aOppUser !== null) {
				if ($this->aOppUser->isModified()) {
					$affectedRows += $this->aOppUser->save($con);
				}
				$this->setOppUser($this->aOppUser);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = sfSimpleBlogPostPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += sfSimpleBlogPostPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collsfSimpleBlogComments !== null) {
				foreach($this->collsfSimpleBlogComments as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collsfSimpleBlogTags !== null) {
				foreach($this->collsfSimpleBlogTags as $referrerFK) {
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


												
			if ($this->aOppUser !== null) {
				if (!$this->aOppUser->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppUser->getValidationFailures());
				}
			}


			if (($retval = sfSimpleBlogPostPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collsfSimpleBlogComments !== null) {
					foreach($this->collsfSimpleBlogComments as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collsfSimpleBlogTags !== null) {
					foreach($this->collsfSimpleBlogTags as $referrerFK) {
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
		$pos = sfSimpleBlogPostPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getAuthorId();
				break;
			case 2:
				return $this->getTitle();
				break;
			case 3:
				return $this->getStrippedTitle();
				break;
			case 4:
				return $this->getExtract();
				break;
			case 5:
				return $this->getContent();
				break;
			case 6:
				return $this->getIsPublished();
				break;
			case 7:
				return $this->getAllowComments();
				break;
			case 8:
				return $this->getCreatedAt();
				break;
			case 9:
				return $this->getPublishedAt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfSimpleBlogPostPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getAuthorId(),
			$keys[2] => $this->getTitle(),
			$keys[3] => $this->getStrippedTitle(),
			$keys[4] => $this->getExtract(),
			$keys[5] => $this->getContent(),
			$keys[6] => $this->getIsPublished(),
			$keys[7] => $this->getAllowComments(),
			$keys[8] => $this->getCreatedAt(),
			$keys[9] => $this->getPublishedAt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = sfSimpleBlogPostPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setAuthorId($value);
				break;
			case 2:
				$this->setTitle($value);
				break;
			case 3:
				$this->setStrippedTitle($value);
				break;
			case 4:
				$this->setExtract($value);
				break;
			case 5:
				$this->setContent($value);
				break;
			case 6:
				$this->setIsPublished($value);
				break;
			case 7:
				$this->setAllowComments($value);
				break;
			case 8:
				$this->setCreatedAt($value);
				break;
			case 9:
				$this->setPublishedAt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = sfSimpleBlogPostPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setAuthorId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTitle($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setStrippedTitle($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setExtract($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setContent($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setIsPublished($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setAllowComments($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setCreatedAt($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setPublishedAt($arr[$keys[9]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(sfSimpleBlogPostPeer::DATABASE_NAME);

		if ($this->isColumnModified(sfSimpleBlogPostPeer::ID)) $criteria->add(sfSimpleBlogPostPeer::ID, $this->id);
		if ($this->isColumnModified(sfSimpleBlogPostPeer::AUTHOR_ID)) $criteria->add(sfSimpleBlogPostPeer::AUTHOR_ID, $this->author_id);
		if ($this->isColumnModified(sfSimpleBlogPostPeer::TITLE)) $criteria->add(sfSimpleBlogPostPeer::TITLE, $this->title);
		if ($this->isColumnModified(sfSimpleBlogPostPeer::STRIPPED_TITLE)) $criteria->add(sfSimpleBlogPostPeer::STRIPPED_TITLE, $this->stripped_title);
		if ($this->isColumnModified(sfSimpleBlogPostPeer::EXTRACT)) $criteria->add(sfSimpleBlogPostPeer::EXTRACT, $this->extract);
		if ($this->isColumnModified(sfSimpleBlogPostPeer::CONTENT)) $criteria->add(sfSimpleBlogPostPeer::CONTENT, $this->content);
		if ($this->isColumnModified(sfSimpleBlogPostPeer::IS_PUBLISHED)) $criteria->add(sfSimpleBlogPostPeer::IS_PUBLISHED, $this->is_published);
		if ($this->isColumnModified(sfSimpleBlogPostPeer::ALLOW_COMMENTS)) $criteria->add(sfSimpleBlogPostPeer::ALLOW_COMMENTS, $this->allow_comments);
		if ($this->isColumnModified(sfSimpleBlogPostPeer::CREATED_AT)) $criteria->add(sfSimpleBlogPostPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(sfSimpleBlogPostPeer::PUBLISHED_AT)) $criteria->add(sfSimpleBlogPostPeer::PUBLISHED_AT, $this->published_at);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(sfSimpleBlogPostPeer::DATABASE_NAME);

		$criteria->add(sfSimpleBlogPostPeer::ID, $this->id);

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

		$copyObj->setAuthorId($this->author_id);

		$copyObj->setTitle($this->title);

		$copyObj->setStrippedTitle($this->stripped_title);

		$copyObj->setExtract($this->extract);

		$copyObj->setContent($this->content);

		$copyObj->setIsPublished($this->is_published);

		$copyObj->setAllowComments($this->allow_comments);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setPublishedAt($this->published_at);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getsfSimpleBlogComments() as $relObj) {
				$copyObj->addsfSimpleBlogComment($relObj->copy($deepCopy));
			}

			foreach($this->getsfSimpleBlogTags() as $relObj) {
				$copyObj->addsfSimpleBlogTag($relObj->copy($deepCopy));
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
			self::$peer = new sfSimpleBlogPostPeer();
		}
		return self::$peer;
	}

	
	public function setOppUser($v)
	{


		if ($v === null) {
			$this->setAuthorId(NULL);
		} else {
			$this->setAuthorId($v->getId());
		}


		$this->aOppUser = $v;
	}


	
	public function getOppUser($con = null)
	{
		if ($this->aOppUser === null && ($this->author_id !== null)) {
						include_once 'lib/model/om/BaseOppUserPeer.php';

			$this->aOppUser = OppUserPeer::retrieveByPK($this->author_id, $con);

			
		}
		return $this->aOppUser;
	}

	
	public function initsfSimpleBlogComments()
	{
		if ($this->collsfSimpleBlogComments === null) {
			$this->collsfSimpleBlogComments = array();
		}
	}

	
	public function getsfSimpleBlogComments($criteria = null, $con = null)
	{
				include_once 'plugins/sfSimpleBlogPlugin/lib/model/om/BasesfSimpleBlogCommentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfSimpleBlogComments === null) {
			if ($this->isNew()) {
			   $this->collsfSimpleBlogComments = array();
			} else {

				$criteria->add(sfSimpleBlogCommentPeer::SF_BLOG_POST_ID, $this->getId());

				sfSimpleBlogCommentPeer::addSelectColumns($criteria);
				$this->collsfSimpleBlogComments = sfSimpleBlogCommentPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(sfSimpleBlogCommentPeer::SF_BLOG_POST_ID, $this->getId());

				sfSimpleBlogCommentPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfSimpleBlogCommentCriteria) || !$this->lastsfSimpleBlogCommentCriteria->equals($criteria)) {
					$this->collsfSimpleBlogComments = sfSimpleBlogCommentPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfSimpleBlogCommentCriteria = $criteria;
		return $this->collsfSimpleBlogComments;
	}

	
	public function countsfSimpleBlogComments($criteria = null, $distinct = false, $con = null)
	{
				include_once 'plugins/sfSimpleBlogPlugin/lib/model/om/BasesfSimpleBlogCommentPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfSimpleBlogCommentPeer::SF_BLOG_POST_ID, $this->getId());

		return sfSimpleBlogCommentPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addsfSimpleBlogComment(sfSimpleBlogComment $l)
	{
		$this->collsfSimpleBlogComments[] = $l;
		$l->setsfSimpleBlogPost($this);
	}

	
	public function initsfSimpleBlogTags()
	{
		if ($this->collsfSimpleBlogTags === null) {
			$this->collsfSimpleBlogTags = array();
		}
	}

	
	public function getsfSimpleBlogTags($criteria = null, $con = null)
	{
				include_once 'plugins/sfSimpleBlogPlugin/lib/model/om/BasesfSimpleBlogTagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collsfSimpleBlogTags === null) {
			if ($this->isNew()) {
			   $this->collsfSimpleBlogTags = array();
			} else {

				$criteria->add(sfSimpleBlogTagPeer::SF_BLOG_POST_ID, $this->getId());

				sfSimpleBlogTagPeer::addSelectColumns($criteria);
				$this->collsfSimpleBlogTags = sfSimpleBlogTagPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(sfSimpleBlogTagPeer::SF_BLOG_POST_ID, $this->getId());

				sfSimpleBlogTagPeer::addSelectColumns($criteria);
				if (!isset($this->lastsfSimpleBlogTagCriteria) || !$this->lastsfSimpleBlogTagCriteria->equals($criteria)) {
					$this->collsfSimpleBlogTags = sfSimpleBlogTagPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastsfSimpleBlogTagCriteria = $criteria;
		return $this->collsfSimpleBlogTags;
	}

	
	public function countsfSimpleBlogTags($criteria = null, $distinct = false, $con = null)
	{
				include_once 'plugins/sfSimpleBlogPlugin/lib/model/om/BasesfSimpleBlogTagPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(sfSimpleBlogTagPeer::SF_BLOG_POST_ID, $this->getId());

		return sfSimpleBlogTagPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addsfSimpleBlogTag(sfSimpleBlogTag $l)
	{
		$this->collsfSimpleBlogTags[] = $l;
		$l->setsfSimpleBlogPost($this);
	}


  public function __call($method, $arguments)
  {
    if (!$callable = sfMixer::getCallable('BasesfSimpleBlogPost:'.$method))
    {
      throw new sfException(sprintf('Call to undefined method BasesfSimpleBlogPost::%s', $method));
    }

    array_unshift($arguments, $this);

    return call_user_func_array($callable, $arguments);
  }


} 