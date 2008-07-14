<?php


abstract class BaseOppTipoAtto extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $denominazione;

	
	protected $collOppAttos;

	
	protected $lastOppAttoCriteria = null;

	
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

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = OppTipoAttoPeer::ID;
		}

	} 
	
	public function setDenominazione($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->denominazione !== $v) {
			$this->denominazione = $v;
			$this->modifiedColumns[] = OppTipoAttoPeer::DENOMINAZIONE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->denominazione = $rs->getString($startcol + 1);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppTipoAtto object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppTipoAttoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppTipoAttoPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppTipoAttoPeer::DATABASE_NAME);
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
					$pk = OppTipoAttoPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OppTipoAttoPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collOppAttos !== null) {
				foreach($this->collOppAttos as $referrerFK) {
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


			if (($retval = OppTipoAttoPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOppAttos !== null) {
					foreach($this->collOppAttos as $referrerFK) {
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
		$pos = OppTipoAttoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppTipoAttoPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getDenominazione(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppTipoAttoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppTipoAttoPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setDenominazione($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppTipoAttoPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppTipoAttoPeer::ID)) $criteria->add(OppTipoAttoPeer::ID, $this->id);
		if ($this->isColumnModified(OppTipoAttoPeer::DENOMINAZIONE)) $criteria->add(OppTipoAttoPeer::DENOMINAZIONE, $this->denominazione);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppTipoAttoPeer::DATABASE_NAME);

		$criteria->add(OppTipoAttoPeer::ID, $this->id);

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


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getOppAttos() as $relObj) {
				$copyObj->addOppAtto($relObj->copy($deepCopy));
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
			self::$peer = new OppTipoAttoPeer();
		}
		return self::$peer;
	}

	
	public function initOppAttos()
	{
		if ($this->collOppAttos === null) {
			$this->collOppAttos = array();
		}
	}

	
	public function getOppAttos($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppAttoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppAttos === null) {
			if ($this->isNew()) {
			   $this->collOppAttos = array();
			} else {

				$criteria->add(OppAttoPeer::TIPO_ATTO_ID, $this->getId());

				OppAttoPeer::addSelectColumns($criteria);
				$this->collOppAttos = OppAttoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppAttoPeer::TIPO_ATTO_ID, $this->getId());

				OppAttoPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppAttoCriteria) || !$this->lastOppAttoCriteria->equals($criteria)) {
					$this->collOppAttos = OppAttoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppAttoCriteria = $criteria;
		return $this->collOppAttos;
	}

	
	public function countOppAttos($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppAttoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppAttoPeer::TIPO_ATTO_ID, $this->getId());

		return OppAttoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppAtto(OppAtto $l)
	{
		$this->collOppAttos[] = $l;
		$l->setOppTipoAtto($this);
	}

} 