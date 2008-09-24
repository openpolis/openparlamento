<?php


abstract class BaseOppTeseott extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $denominazione;


	
	protected $ns_denominazione;


	
	protected $teseo_senato;

	
	protected $collOppTeseos;

	
	protected $lastOppTeseoCriteria = null;

	
	protected $collOppTeseoHasTeseotts;

	
	protected $lastOppTeseoHasTeseottCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getDenominazione()
	{

		return $this->denominazione;
	}

	
	public function getNsDenominazione()
	{

		return $this->ns_denominazione;
	}

	
	public function getTeseoSenato()
	{

		return $this->teseo_senato;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = OppTeseottPeer::ID;
		}

	} 
	
	public function setDenominazione($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->denominazione !== $v) {
			$this->denominazione = $v;
			$this->modifiedColumns[] = OppTeseottPeer::DENOMINAZIONE;
		}

	} 
	
	public function setNsDenominazione($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->ns_denominazione !== $v) {
			$this->ns_denominazione = $v;
			$this->modifiedColumns[] = OppTeseottPeer::NS_DENOMINAZIONE;
		}

	} 
	
	public function setTeseoSenato($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->teseo_senato !== $v) {
			$this->teseo_senato = $v;
			$this->modifiedColumns[] = OppTeseottPeer::TESEO_SENATO;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->denominazione = $rs->getString($startcol + 1);

			$this->ns_denominazione = $rs->getString($startcol + 2);

			$this->teseo_senato = $rs->getInt($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppTeseott object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppTeseottPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppTeseottPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppTeseottPeer::DATABASE_NAME);
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
					$pk = OppTeseottPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OppTeseottPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collOppTeseos !== null) {
				foreach($this->collOppTeseos as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOppTeseoHasTeseotts !== null) {
				foreach($this->collOppTeseoHasTeseotts as $referrerFK) {
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


			if (($retval = OppTeseottPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOppTeseos !== null) {
					foreach($this->collOppTeseos as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOppTeseoHasTeseotts !== null) {
					foreach($this->collOppTeseoHasTeseotts as $referrerFK) {
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
		$pos = OppTeseottPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getDenominazione();
				break;
			case 2:
				return $this->getNsDenominazione();
				break;
			case 3:
				return $this->getTeseoSenato();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppTeseottPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getDenominazione(),
			$keys[2] => $this->getNsDenominazione(),
			$keys[3] => $this->getTeseoSenato(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppTeseottPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setDenominazione($value);
				break;
			case 2:
				$this->setNsDenominazione($value);
				break;
			case 3:
				$this->setTeseoSenato($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppTeseottPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setDenominazione($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setNsDenominazione($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTeseoSenato($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppTeseottPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppTeseottPeer::ID)) $criteria->add(OppTeseottPeer::ID, $this->id);
		if ($this->isColumnModified(OppTeseottPeer::DENOMINAZIONE)) $criteria->add(OppTeseottPeer::DENOMINAZIONE, $this->denominazione);
		if ($this->isColumnModified(OppTeseottPeer::NS_DENOMINAZIONE)) $criteria->add(OppTeseottPeer::NS_DENOMINAZIONE, $this->ns_denominazione);
		if ($this->isColumnModified(OppTeseottPeer::TESEO_SENATO)) $criteria->add(OppTeseottPeer::TESEO_SENATO, $this->teseo_senato);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppTeseottPeer::DATABASE_NAME);

		$criteria->add(OppTeseottPeer::ID, $this->id);

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

		$copyObj->setDenominazione($this->denominazione);

		$copyObj->setNsDenominazione($this->ns_denominazione);

		$copyObj->setTeseoSenato($this->teseo_senato);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getOppTeseos() as $relObj) {
				$copyObj->addOppTeseo($relObj->copy($deepCopy));
			}

			foreach($this->getOppTeseoHasTeseotts() as $relObj) {
				$copyObj->addOppTeseoHasTeseott($relObj->copy($deepCopy));
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
			self::$peer = new OppTeseottPeer();
		}
		return self::$peer;
	}

	
	public function initOppTeseos()
	{
		if ($this->collOppTeseos === null) {
			$this->collOppTeseos = array();
		}
	}

	
	public function getOppTeseos($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppTeseoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppTeseos === null) {
			if ($this->isNew()) {
			   $this->collOppTeseos = array();
			} else {

				$criteria->add(OppTeseoPeer::TESEOTT_ID, $this->getId());

				OppTeseoPeer::addSelectColumns($criteria);
				$this->collOppTeseos = OppTeseoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppTeseoPeer::TESEOTT_ID, $this->getId());

				OppTeseoPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppTeseoCriteria) || !$this->lastOppTeseoCriteria->equals($criteria)) {
					$this->collOppTeseos = OppTeseoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppTeseoCriteria = $criteria;
		return $this->collOppTeseos;
	}

	
	public function countOppTeseos($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppTeseoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppTeseoPeer::TESEOTT_ID, $this->getId());

		return OppTeseoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppTeseo(OppTeseo $l)
	{
		$this->collOppTeseos[] = $l;
		$l->setOppTeseott($this);
	}


	
	public function getOppTeseosJoinOppTipoTeseo($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppTeseoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppTeseos === null) {
			if ($this->isNew()) {
				$this->collOppTeseos = array();
			} else {

				$criteria->add(OppTeseoPeer::TESEOTT_ID, $this->getId());

				$this->collOppTeseos = OppTeseoPeer::doSelectJoinOppTipoTeseo($criteria, $con);
			}
		} else {
									
			$criteria->add(OppTeseoPeer::TESEOTT_ID, $this->getId());

			if (!isset($this->lastOppTeseoCriteria) || !$this->lastOppTeseoCriteria->equals($criteria)) {
				$this->collOppTeseos = OppTeseoPeer::doSelectJoinOppTipoTeseo($criteria, $con);
			}
		}
		$this->lastOppTeseoCriteria = $criteria;

		return $this->collOppTeseos;
	}

	
	public function initOppTeseoHasTeseotts()
	{
		if ($this->collOppTeseoHasTeseotts === null) {
			$this->collOppTeseoHasTeseotts = array();
		}
	}

	
	public function getOppTeseoHasTeseotts($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppTeseoHasTeseottPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppTeseoHasTeseotts === null) {
			if ($this->isNew()) {
			   $this->collOppTeseoHasTeseotts = array();
			} else {

				$criteria->add(OppTeseoHasTeseottPeer::OPP_TESEOTT_ID, $this->getId());

				OppTeseoHasTeseottPeer::addSelectColumns($criteria);
				$this->collOppTeseoHasTeseotts = OppTeseoHasTeseottPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppTeseoHasTeseottPeer::OPP_TESEOTT_ID, $this->getId());

				OppTeseoHasTeseottPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppTeseoHasTeseottCriteria) || !$this->lastOppTeseoHasTeseottCriteria->equals($criteria)) {
					$this->collOppTeseoHasTeseotts = OppTeseoHasTeseottPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppTeseoHasTeseottCriteria = $criteria;
		return $this->collOppTeseoHasTeseotts;
	}

	
	public function countOppTeseoHasTeseotts($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppTeseoHasTeseottPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppTeseoHasTeseottPeer::OPP_TESEOTT_ID, $this->getId());

		return OppTeseoHasTeseottPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppTeseoHasTeseott(OppTeseoHasTeseott $l)
	{
		$this->collOppTeseoHasTeseotts[] = $l;
		$l->setOppTeseott($this);
	}


	
	public function getOppTeseoHasTeseottsJoinOppTeseo($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppTeseoHasTeseottPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppTeseoHasTeseotts === null) {
			if ($this->isNew()) {
				$this->collOppTeseoHasTeseotts = array();
			} else {

				$criteria->add(OppTeseoHasTeseottPeer::OPP_TESEOTT_ID, $this->getId());

				$this->collOppTeseoHasTeseotts = OppTeseoHasTeseottPeer::doSelectJoinOppTeseo($criteria, $con);
			}
		} else {
									
			$criteria->add(OppTeseoHasTeseottPeer::OPP_TESEOTT_ID, $this->getId());

			if (!isset($this->lastOppTeseoHasTeseottCriteria) || !$this->lastOppTeseoHasTeseottCriteria->equals($criteria)) {
				$this->collOppTeseoHasTeseotts = OppTeseoHasTeseottPeer::doSelectJoinOppTeseo($criteria, $con);
			}
		}
		$this->lastOppTeseoHasTeseottCriteria = $criteria;

		return $this->collOppTeseoHasTeseotts;
	}

} 