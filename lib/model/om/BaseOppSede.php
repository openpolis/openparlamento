<?php


abstract class BaseOppSede extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $ramo;


	
	protected $denominazione;


	
	protected $legislatura;


	
	protected $tipologia;


	
	protected $codice;

	
	protected $collOppAttoHasSedes;

	
	protected $lastOppAttoHasSedeCriteria = null;

	
	protected $collOppInterventos;

	
	protected $lastOppInterventoCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getRamo()
	{

		return $this->ramo;
	}

	
	public function getDenominazione()
	{

		return $this->denominazione;
	}

	
	public function getLegislatura()
	{

		return $this->legislatura;
	}

	
	public function getTipologia()
	{

		return $this->tipologia;
	}

	
	public function getCodice()
	{

		return $this->codice;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = OppSedePeer::ID;
		}

	} 
	
	public function setRamo($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->ramo !== $v) {
			$this->ramo = $v;
			$this->modifiedColumns[] = OppSedePeer::RAMO;
		}

	} 
	
	public function setDenominazione($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->denominazione !== $v) {
			$this->denominazione = $v;
			$this->modifiedColumns[] = OppSedePeer::DENOMINAZIONE;
		}

	} 
	
	public function setLegislatura($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->legislatura !== $v) {
			$this->legislatura = $v;
			$this->modifiedColumns[] = OppSedePeer::LEGISLATURA;
		}

	} 
	
	public function setTipologia($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->tipologia !== $v) {
			$this->tipologia = $v;
			$this->modifiedColumns[] = OppSedePeer::TIPOLOGIA;
		}

	} 
	
	public function setCodice($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->codice !== $v) {
			$this->codice = $v;
			$this->modifiedColumns[] = OppSedePeer::CODICE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->ramo = $rs->getString($startcol + 1);

			$this->denominazione = $rs->getString($startcol + 2);

			$this->legislatura = $rs->getInt($startcol + 3);

			$this->tipologia = $rs->getString($startcol + 4);

			$this->codice = $rs->getString($startcol + 5);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppSede object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppSedePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppSedePeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppSedePeer::DATABASE_NAME);
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
					$pk = OppSedePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OppSedePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collOppAttoHasSedes !== null) {
				foreach($this->collOppAttoHasSedes as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOppInterventos !== null) {
				foreach($this->collOppInterventos as $referrerFK) {
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


			if (($retval = OppSedePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOppAttoHasSedes !== null) {
					foreach($this->collOppAttoHasSedes as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOppInterventos !== null) {
					foreach($this->collOppInterventos as $referrerFK) {
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
		$pos = OppSedePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getRamo();
				break;
			case 2:
				return $this->getDenominazione();
				break;
			case 3:
				return $this->getLegislatura();
				break;
			case 4:
				return $this->getTipologia();
				break;
			case 5:
				return $this->getCodice();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppSedePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getRamo(),
			$keys[2] => $this->getDenominazione(),
			$keys[3] => $this->getLegislatura(),
			$keys[4] => $this->getTipologia(),
			$keys[5] => $this->getCodice(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppSedePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setRamo($value);
				break;
			case 2:
				$this->setDenominazione($value);
				break;
			case 3:
				$this->setLegislatura($value);
				break;
			case 4:
				$this->setTipologia($value);
				break;
			case 5:
				$this->setCodice($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppSedePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setRamo($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDenominazione($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setLegislatura($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setTipologia($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setCodice($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppSedePeer::DATABASE_NAME);

		if ($this->isColumnModified(OppSedePeer::ID)) $criteria->add(OppSedePeer::ID, $this->id);
		if ($this->isColumnModified(OppSedePeer::RAMO)) $criteria->add(OppSedePeer::RAMO, $this->ramo);
		if ($this->isColumnModified(OppSedePeer::DENOMINAZIONE)) $criteria->add(OppSedePeer::DENOMINAZIONE, $this->denominazione);
		if ($this->isColumnModified(OppSedePeer::LEGISLATURA)) $criteria->add(OppSedePeer::LEGISLATURA, $this->legislatura);
		if ($this->isColumnModified(OppSedePeer::TIPOLOGIA)) $criteria->add(OppSedePeer::TIPOLOGIA, $this->tipologia);
		if ($this->isColumnModified(OppSedePeer::CODICE)) $criteria->add(OppSedePeer::CODICE, $this->codice);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppSedePeer::DATABASE_NAME);

		$criteria->add(OppSedePeer::ID, $this->id);

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

		$copyObj->setRamo($this->ramo);

		$copyObj->setDenominazione($this->denominazione);

		$copyObj->setLegislatura($this->legislatura);

		$copyObj->setTipologia($this->tipologia);

		$copyObj->setCodice($this->codice);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getOppAttoHasSedes() as $relObj) {
				$copyObj->addOppAttoHasSede($relObj->copy($deepCopy));
			}

			foreach($this->getOppInterventos() as $relObj) {
				$copyObj->addOppIntervento($relObj->copy($deepCopy));
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
			self::$peer = new OppSedePeer();
		}
		return self::$peer;
	}

	
	public function initOppAttoHasSedes()
	{
		if ($this->collOppAttoHasSedes === null) {
			$this->collOppAttoHasSedes = array();
		}
	}

	
	public function getOppAttoHasSedes($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppAttoHasSedePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppAttoHasSedes === null) {
			if ($this->isNew()) {
			   $this->collOppAttoHasSedes = array();
			} else {

				$criteria->add(OppAttoHasSedePeer::SEDE_ID, $this->getId());

				OppAttoHasSedePeer::addSelectColumns($criteria);
				$this->collOppAttoHasSedes = OppAttoHasSedePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppAttoHasSedePeer::SEDE_ID, $this->getId());

				OppAttoHasSedePeer::addSelectColumns($criteria);
				if (!isset($this->lastOppAttoHasSedeCriteria) || !$this->lastOppAttoHasSedeCriteria->equals($criteria)) {
					$this->collOppAttoHasSedes = OppAttoHasSedePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppAttoHasSedeCriteria = $criteria;
		return $this->collOppAttoHasSedes;
	}

	
	public function countOppAttoHasSedes($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppAttoHasSedePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppAttoHasSedePeer::SEDE_ID, $this->getId());

		return OppAttoHasSedePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppAttoHasSede(OppAttoHasSede $l)
	{
		$this->collOppAttoHasSedes[] = $l;
		$l->setOppSede($this);
	}


	
	public function getOppAttoHasSedesJoinOppAtto($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppAttoHasSedePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppAttoHasSedes === null) {
			if ($this->isNew()) {
				$this->collOppAttoHasSedes = array();
			} else {

				$criteria->add(OppAttoHasSedePeer::SEDE_ID, $this->getId());

				$this->collOppAttoHasSedes = OppAttoHasSedePeer::doSelectJoinOppAtto($criteria, $con);
			}
		} else {
									
			$criteria->add(OppAttoHasSedePeer::SEDE_ID, $this->getId());

			if (!isset($this->lastOppAttoHasSedeCriteria) || !$this->lastOppAttoHasSedeCriteria->equals($criteria)) {
				$this->collOppAttoHasSedes = OppAttoHasSedePeer::doSelectJoinOppAtto($criteria, $con);
			}
		}
		$this->lastOppAttoHasSedeCriteria = $criteria;

		return $this->collOppAttoHasSedes;
	}

	
	public function initOppInterventos()
	{
		if ($this->collOppInterventos === null) {
			$this->collOppInterventos = array();
		}
	}

	
	public function getOppInterventos($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppInterventoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppInterventos === null) {
			if ($this->isNew()) {
			   $this->collOppInterventos = array();
			} else {

				$criteria->add(OppInterventoPeer::SEDE_ID, $this->getId());

				OppInterventoPeer::addSelectColumns($criteria);
				$this->collOppInterventos = OppInterventoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppInterventoPeer::SEDE_ID, $this->getId());

				OppInterventoPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppInterventoCriteria) || !$this->lastOppInterventoCriteria->equals($criteria)) {
					$this->collOppInterventos = OppInterventoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppInterventoCriteria = $criteria;
		return $this->collOppInterventos;
	}

	
	public function countOppInterventos($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppInterventoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppInterventoPeer::SEDE_ID, $this->getId());

		return OppInterventoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppIntervento(OppIntervento $l)
	{
		$this->collOppInterventos[] = $l;
		$l->setOppSede($this);
	}


	
	public function getOppInterventosJoinOppAtto($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppInterventoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppInterventos === null) {
			if ($this->isNew()) {
				$this->collOppInterventos = array();
			} else {

				$criteria->add(OppInterventoPeer::SEDE_ID, $this->getId());

				$this->collOppInterventos = OppInterventoPeer::doSelectJoinOppAtto($criteria, $con);
			}
		} else {
									
			$criteria->add(OppInterventoPeer::SEDE_ID, $this->getId());

			if (!isset($this->lastOppInterventoCriteria) || !$this->lastOppInterventoCriteria->equals($criteria)) {
				$this->collOppInterventos = OppInterventoPeer::doSelectJoinOppAtto($criteria, $con);
			}
		}
		$this->lastOppInterventoCriteria = $criteria;

		return $this->collOppInterventos;
	}


	
	public function getOppInterventosJoinOppCarica($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppInterventoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppInterventos === null) {
			if ($this->isNew()) {
				$this->collOppInterventos = array();
			} else {

				$criteria->add(OppInterventoPeer::SEDE_ID, $this->getId());

				$this->collOppInterventos = OppInterventoPeer::doSelectJoinOppCarica($criteria, $con);
			}
		} else {
									
			$criteria->add(OppInterventoPeer::SEDE_ID, $this->getId());

			if (!isset($this->lastOppInterventoCriteria) || !$this->lastOppInterventoCriteria->equals($criteria)) {
				$this->collOppInterventos = OppInterventoPeer::doSelectJoinOppCarica($criteria, $con);
			}
		}
		$this->lastOppInterventoCriteria = $criteria;

		return $this->collOppInterventos;
	}

} 