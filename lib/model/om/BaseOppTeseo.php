<?php


abstract class BaseOppTeseo extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $tipo_teseo_id;


	
	protected $denominazione;


	
	protected $ns_denominazione;


	
	protected $teseott_id;


	
	protected $tt;

	
	protected $aOppTipoTeseo;

	
	protected $aOppTeseott;

	
	protected $collOppAttoHasTeseos;

	
	protected $lastOppAttoHasTeseoCriteria = null;

	
	protected $collOppTeseoHasTeseotts;

	
	protected $lastOppTeseoHasTeseottCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getTipoTeseoId()
	{

		return $this->tipo_teseo_id;
	}

	
	public function getDenominazione()
	{

		return $this->denominazione;
	}

	
	public function getNsDenominazione()
	{

		return $this->ns_denominazione;
	}

	
	public function getTeseottId()
	{

		return $this->teseott_id;
	}

	
	public function getTt()
	{

		return $this->tt;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = OppTeseoPeer::ID;
		}

	} 
	
	public function setTipoTeseoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->tipo_teseo_id !== $v) {
			$this->tipo_teseo_id = $v;
			$this->modifiedColumns[] = OppTeseoPeer::TIPO_TESEO_ID;
		}

		if ($this->aOppTipoTeseo !== null && $this->aOppTipoTeseo->getId() !== $v) {
			$this->aOppTipoTeseo = null;
		}

	} 
	
	public function setDenominazione($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->denominazione !== $v) {
			$this->denominazione = $v;
			$this->modifiedColumns[] = OppTeseoPeer::DENOMINAZIONE;
		}

	} 
	
	public function setNsDenominazione($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->ns_denominazione !== $v) {
			$this->ns_denominazione = $v;
			$this->modifiedColumns[] = OppTeseoPeer::NS_DENOMINAZIONE;
		}

	} 
	
	public function setTeseottId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->teseott_id !== $v) {
			$this->teseott_id = $v;
			$this->modifiedColumns[] = OppTeseoPeer::TESEOTT_ID;
		}

		if ($this->aOppTeseott !== null && $this->aOppTeseott->getId() !== $v) {
			$this->aOppTeseott = null;
		}

	} 
	
	public function setTt($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->tt !== $v) {
			$this->tt = $v;
			$this->modifiedColumns[] = OppTeseoPeer::TT;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->tipo_teseo_id = $rs->getInt($startcol + 1);

			$this->denominazione = $rs->getString($startcol + 2);

			$this->ns_denominazione = $rs->getString($startcol + 3);

			$this->teseott_id = $rs->getInt($startcol + 4);

			$this->tt = $rs->getInt($startcol + 5);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppTeseo object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppTeseoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppTeseoPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppTeseoPeer::DATABASE_NAME);
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


												
			if ($this->aOppTipoTeseo !== null) {
				if ($this->aOppTipoTeseo->isModified()) {
					$affectedRows += $this->aOppTipoTeseo->save($con);
				}
				$this->setOppTipoTeseo($this->aOppTipoTeseo);
			}

			if ($this->aOppTeseott !== null) {
				if ($this->aOppTeseott->isModified()) {
					$affectedRows += $this->aOppTeseott->save($con);
				}
				$this->setOppTeseott($this->aOppTeseott);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppTeseoPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OppTeseoPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collOppAttoHasTeseos !== null) {
				foreach($this->collOppAttoHasTeseos as $referrerFK) {
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


												
			if ($this->aOppTipoTeseo !== null) {
				if (!$this->aOppTipoTeseo->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppTipoTeseo->getValidationFailures());
				}
			}

			if ($this->aOppTeseott !== null) {
				if (!$this->aOppTeseott->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppTeseott->getValidationFailures());
				}
			}


			if (($retval = OppTeseoPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOppAttoHasTeseos !== null) {
					foreach($this->collOppAttoHasTeseos as $referrerFK) {
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
		$pos = OppTeseoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getTipoTeseoId();
				break;
			case 2:
				return $this->getDenominazione();
				break;
			case 3:
				return $this->getNsDenominazione();
				break;
			case 4:
				return $this->getTeseottId();
				break;
			case 5:
				return $this->getTt();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppTeseoPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTipoTeseoId(),
			$keys[2] => $this->getDenominazione(),
			$keys[3] => $this->getNsDenominazione(),
			$keys[4] => $this->getTeseottId(),
			$keys[5] => $this->getTt(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppTeseoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setTipoTeseoId($value);
				break;
			case 2:
				$this->setDenominazione($value);
				break;
			case 3:
				$this->setNsDenominazione($value);
				break;
			case 4:
				$this->setTeseottId($value);
				break;
			case 5:
				$this->setTt($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppTeseoPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTipoTeseoId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDenominazione($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setNsDenominazione($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setTeseottId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setTt($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppTeseoPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppTeseoPeer::ID)) $criteria->add(OppTeseoPeer::ID, $this->id);
		if ($this->isColumnModified(OppTeseoPeer::TIPO_TESEO_ID)) $criteria->add(OppTeseoPeer::TIPO_TESEO_ID, $this->tipo_teseo_id);
		if ($this->isColumnModified(OppTeseoPeer::DENOMINAZIONE)) $criteria->add(OppTeseoPeer::DENOMINAZIONE, $this->denominazione);
		if ($this->isColumnModified(OppTeseoPeer::NS_DENOMINAZIONE)) $criteria->add(OppTeseoPeer::NS_DENOMINAZIONE, $this->ns_denominazione);
		if ($this->isColumnModified(OppTeseoPeer::TESEOTT_ID)) $criteria->add(OppTeseoPeer::TESEOTT_ID, $this->teseott_id);
		if ($this->isColumnModified(OppTeseoPeer::TT)) $criteria->add(OppTeseoPeer::TT, $this->tt);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppTeseoPeer::DATABASE_NAME);

		$criteria->add(OppTeseoPeer::ID, $this->id);
		$criteria->add(OppTeseoPeer::TIPO_TESEO_ID, $this->tipo_teseo_id);
		$criteria->add(OppTeseoPeer::TESEOTT_ID, $this->teseott_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getId();

		$pks[1] = $this->getTipoTeseoId();

		$pks[2] = $this->getTeseottId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setId($keys[0]);

		$this->setTipoTeseoId($keys[1]);

		$this->setTeseottId($keys[2]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setDenominazione($this->denominazione);

		$copyObj->setNsDenominazione($this->ns_denominazione);

		$copyObj->setTt($this->tt);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getOppAttoHasTeseos() as $relObj) {
				$copyObj->addOppAttoHasTeseo($relObj->copy($deepCopy));
			}

			foreach($this->getOppTeseoHasTeseotts() as $relObj) {
				$copyObj->addOppTeseoHasTeseott($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
		$copyObj->setTipoTeseoId(NULL); 
		$copyObj->setTeseottId(NULL); 
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
			self::$peer = new OppTeseoPeer();
		}
		return self::$peer;
	}

	
	public function setOppTipoTeseo($v)
	{


		if ($v === null) {
			$this->setTipoTeseoId(NULL);
		} else {
			$this->setTipoTeseoId($v->getId());
		}


		$this->aOppTipoTeseo = $v;
	}


	
	public function getOppTipoTeseo($con = null)
	{
				include_once 'lib/model/om/BaseOppTipoTeseoPeer.php';

		if ($this->aOppTipoTeseo === null && ($this->tipo_teseo_id !== null)) {

			$this->aOppTipoTeseo = OppTipoTeseoPeer::retrieveByPK($this->tipo_teseo_id, $con);

			
		}
		return $this->aOppTipoTeseo;
	}

	
	public function setOppTeseott($v)
	{


		if ($v === null) {
			$this->setTeseottId(NULL);
		} else {
			$this->setTeseottId($v->getId());
		}


		$this->aOppTeseott = $v;
	}


	
	public function getOppTeseott($con = null)
	{
				include_once 'lib/model/om/BaseOppTeseottPeer.php';

		if ($this->aOppTeseott === null && ($this->teseott_id !== null)) {

			$this->aOppTeseott = OppTeseottPeer::retrieveByPK($this->teseott_id, $con);

			
		}
		return $this->aOppTeseott;
	}

	
	public function initOppAttoHasTeseos()
	{
		if ($this->collOppAttoHasTeseos === null) {
			$this->collOppAttoHasTeseos = array();
		}
	}

	
	public function getOppAttoHasTeseos($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppAttoHasTeseoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppAttoHasTeseos === null) {
			if ($this->isNew()) {
			   $this->collOppAttoHasTeseos = array();
			} else {

				$criteria->add(OppAttoHasTeseoPeer::TESEO_ID, $this->getId());

				OppAttoHasTeseoPeer::addSelectColumns($criteria);
				$this->collOppAttoHasTeseos = OppAttoHasTeseoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppAttoHasTeseoPeer::TESEO_ID, $this->getId());

				OppAttoHasTeseoPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppAttoHasTeseoCriteria) || !$this->lastOppAttoHasTeseoCriteria->equals($criteria)) {
					$this->collOppAttoHasTeseos = OppAttoHasTeseoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppAttoHasTeseoCriteria = $criteria;
		return $this->collOppAttoHasTeseos;
	}

	
	public function countOppAttoHasTeseos($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppAttoHasTeseoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppAttoHasTeseoPeer::TESEO_ID, $this->getId());

		return OppAttoHasTeseoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppAttoHasTeseo(OppAttoHasTeseo $l)
	{
		$this->collOppAttoHasTeseos[] = $l;
		$l->setOppTeseo($this);
	}


	
	public function getOppAttoHasTeseosJoinOppAtto($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppAttoHasTeseoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppAttoHasTeseos === null) {
			if ($this->isNew()) {
				$this->collOppAttoHasTeseos = array();
			} else {

				$criteria->add(OppAttoHasTeseoPeer::TESEO_ID, $this->getId());

				$this->collOppAttoHasTeseos = OppAttoHasTeseoPeer::doSelectJoinOppAtto($criteria, $con);
			}
		} else {
									
			$criteria->add(OppAttoHasTeseoPeer::TESEO_ID, $this->getId());

			if (!isset($this->lastOppAttoHasTeseoCriteria) || !$this->lastOppAttoHasTeseoCriteria->equals($criteria)) {
				$this->collOppAttoHasTeseos = OppAttoHasTeseoPeer::doSelectJoinOppAtto($criteria, $con);
			}
		}
		$this->lastOppAttoHasTeseoCriteria = $criteria;

		return $this->collOppAttoHasTeseos;
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

				$criteria->add(OppTeseoHasTeseottPeer::OPP_TESEO_ID, $this->getId());

				OppTeseoHasTeseottPeer::addSelectColumns($criteria);
				$this->collOppTeseoHasTeseotts = OppTeseoHasTeseottPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppTeseoHasTeseottPeer::OPP_TESEO_ID, $this->getId());

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

		$criteria->add(OppTeseoHasTeseottPeer::OPP_TESEO_ID, $this->getId());

		return OppTeseoHasTeseottPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppTeseoHasTeseott(OppTeseoHasTeseott $l)
	{
		$this->collOppTeseoHasTeseotts[] = $l;
		$l->setOppTeseo($this);
	}


	
	public function getOppTeseoHasTeseottsJoinOppTeseott($criteria = null, $con = null)
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

				$criteria->add(OppTeseoHasTeseottPeer::OPP_TESEO_ID, $this->getId());

				$this->collOppTeseoHasTeseotts = OppTeseoHasTeseottPeer::doSelectJoinOppTeseott($criteria, $con);
			}
		} else {
									
			$criteria->add(OppTeseoHasTeseottPeer::OPP_TESEO_ID, $this->getId());

			if (!isset($this->lastOppTeseoHasTeseottCriteria) || !$this->lastOppTeseoHasTeseottCriteria->equals($criteria)) {
				$this->collOppTeseoHasTeseotts = OppTeseoHasTeseottPeer::doSelectJoinOppTeseott($criteria, $con);
			}
		}
		$this->lastOppTeseoHasTeseottCriteria = $criteria;

		return $this->collOppTeseoHasTeseotts;
	}

} 