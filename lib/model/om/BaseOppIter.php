<?php


abstract class BaseOppIter extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $fase;


	
	protected $concluso;

	
	protected $collOppAttoHasIters;

	
	protected $lastOppAttoHasIterCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getFase()
	{

		return $this->fase;
	}

	
	public function getConcluso()
	{

		return $this->concluso;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = OppIterPeer::ID;
		}

	} 
	
	public function setFase($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->fase !== $v) {
			$this->fase = $v;
			$this->modifiedColumns[] = OppIterPeer::FASE;
		}

	} 
	
	public function setConcluso($v)
	{

		if ($this->concluso !== $v) {
			$this->concluso = $v;
			$this->modifiedColumns[] = OppIterPeer::CONCLUSO;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->fase = $rs->getString($startcol + 1);

			$this->concluso = $rs->getBoolean($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppIter object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppIterPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppIterPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppIterPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
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
					$pk = OppIterPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OppIterPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collOppAttoHasIters !== null) {
				foreach($this->collOppAttoHasIters as $referrerFK) {
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


			if (($retval = OppIterPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOppAttoHasIters !== null) {
					foreach($this->collOppAttoHasIters as $referrerFK) {
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
		$pos = OppIterPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getFase();
				break;
			case 2:
				return $this->getConcluso();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppIterPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getFase(),
			$keys[2] => $this->getConcluso(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppIterPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setFase($value);
				break;
			case 2:
				$this->setConcluso($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppIterPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setFase($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setConcluso($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppIterPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppIterPeer::ID)) $criteria->add(OppIterPeer::ID, $this->id);
		if ($this->isColumnModified(OppIterPeer::FASE)) $criteria->add(OppIterPeer::FASE, $this->fase);
		if ($this->isColumnModified(OppIterPeer::CONCLUSO)) $criteria->add(OppIterPeer::CONCLUSO, $this->concluso);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppIterPeer::DATABASE_NAME);

		$criteria->add(OppIterPeer::ID, $this->id);

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

		$copyObj->setFase($this->fase);

		$copyObj->setConcluso($this->concluso);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getOppAttoHasIters() as $relObj) {
				$copyObj->addOppAttoHasIter($relObj->copy($deepCopy));
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
			self::$peer = new OppIterPeer();
		}
		return self::$peer;
	}

	
	public function initOppAttoHasIters()
	{
		if ($this->collOppAttoHasIters === null) {
			$this->collOppAttoHasIters = array();
		}
	}

	
	public function getOppAttoHasIters($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppAttoHasIterPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppAttoHasIters === null) {
			if ($this->isNew()) {
			   $this->collOppAttoHasIters = array();
			} else {

				$criteria->add(OppAttoHasIterPeer::ITER_ID, $this->getId());

				OppAttoHasIterPeer::addSelectColumns($criteria);
				$this->collOppAttoHasIters = OppAttoHasIterPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppAttoHasIterPeer::ITER_ID, $this->getId());

				OppAttoHasIterPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppAttoHasIterCriteria) || !$this->lastOppAttoHasIterCriteria->equals($criteria)) {
					$this->collOppAttoHasIters = OppAttoHasIterPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppAttoHasIterCriteria = $criteria;
		return $this->collOppAttoHasIters;
	}

	
	public function countOppAttoHasIters($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppAttoHasIterPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppAttoHasIterPeer::ITER_ID, $this->getId());

		return OppAttoHasIterPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppAttoHasIter(OppAttoHasIter $l)
	{
		$this->collOppAttoHasIters[] = $l;
		$l->setOppIter($this);
	}


	
	public function getOppAttoHasItersJoinOppAtto($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppAttoHasIterPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppAttoHasIters === null) {
			if ($this->isNew()) {
				$this->collOppAttoHasIters = array();
			} else {

				$criteria->add(OppAttoHasIterPeer::ITER_ID, $this->getId());

				$this->collOppAttoHasIters = OppAttoHasIterPeer::doSelectJoinOppAtto($criteria, $con);
			}
		} else {
									
			$criteria->add(OppAttoHasIterPeer::ITER_ID, $this->getId());

			if (!isset($this->lastOppAttoHasIterCriteria) || !$this->lastOppAttoHasIterCriteria->equals($criteria)) {
				$this->collOppAttoHasIters = OppAttoHasIterPeer::doSelectJoinOppAtto($criteria, $con);
			}
		}
		$this->lastOppAttoHasIterCriteria = $criteria;

		return $this->collOppAttoHasIters;
	}

} 