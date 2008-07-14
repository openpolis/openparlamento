<?php


abstract class BaseOppAppoggio extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $carica_id;


	
	protected $aka;


	
	protected $tipologia;


	
	protected $legislatura;

	
	protected $aOppCarica;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getCaricaId()
	{

		return $this->carica_id;
	}

	
	public function getAka()
	{

		return $this->aka;
	}

	
	public function getTipologia()
	{

		return $this->tipologia;
	}

	
	public function getLegislatura()
	{

		return $this->legislatura;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = OppAppoggioPeer::ID;
		}

	} 
	
	public function setCaricaId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->carica_id !== $v) {
			$this->carica_id = $v;
			$this->modifiedColumns[] = OppAppoggioPeer::CARICA_ID;
		}

		if ($this->aOppCarica !== null && $this->aOppCarica->getId() !== $v) {
			$this->aOppCarica = null;
		}

	} 
	
	public function setAka($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->aka !== $v) {
			$this->aka = $v;
			$this->modifiedColumns[] = OppAppoggioPeer::AKA;
		}

	} 
	
	public function setTipologia($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->tipologia !== $v) {
			$this->tipologia = $v;
			$this->modifiedColumns[] = OppAppoggioPeer::TIPOLOGIA;
		}

	} 
	
	public function setLegislatura($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->legislatura !== $v) {
			$this->legislatura = $v;
			$this->modifiedColumns[] = OppAppoggioPeer::LEGISLATURA;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->carica_id = $rs->getInt($startcol + 1);

			$this->aka = $rs->getString($startcol + 2);

			$this->tipologia = $rs->getInt($startcol + 3);

			$this->legislatura = $rs->getInt($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppAppoggio object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppAppoggioPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppAppoggioPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppAppoggioPeer::DATABASE_NAME);
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


												
			if ($this->aOppCarica !== null) {
				if ($this->aOppCarica->isModified()) {
					$affectedRows += $this->aOppCarica->save($con);
				}
				$this->setOppCarica($this->aOppCarica);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppAppoggioPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OppAppoggioPeer::doUpdate($this, $con);
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


												
			if ($this->aOppCarica !== null) {
				if (!$this->aOppCarica->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppCarica->getValidationFailures());
				}
			}


			if (($retval = OppAppoggioPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppAppoggioPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getCaricaId();
				break;
			case 2:
				return $this->getAka();
				break;
			case 3:
				return $this->getTipologia();
				break;
			case 4:
				return $this->getLegislatura();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppAppoggioPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCaricaId(),
			$keys[2] => $this->getAka(),
			$keys[3] => $this->getTipologia(),
			$keys[4] => $this->getLegislatura(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppAppoggioPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setCaricaId($value);
				break;
			case 2:
				$this->setAka($value);
				break;
			case 3:
				$this->setTipologia($value);
				break;
			case 4:
				$this->setLegislatura($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppAppoggioPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCaricaId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setAka($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setTipologia($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setLegislatura($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppAppoggioPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppAppoggioPeer::ID)) $criteria->add(OppAppoggioPeer::ID, $this->id);
		if ($this->isColumnModified(OppAppoggioPeer::CARICA_ID)) $criteria->add(OppAppoggioPeer::CARICA_ID, $this->carica_id);
		if ($this->isColumnModified(OppAppoggioPeer::AKA)) $criteria->add(OppAppoggioPeer::AKA, $this->aka);
		if ($this->isColumnModified(OppAppoggioPeer::TIPOLOGIA)) $criteria->add(OppAppoggioPeer::TIPOLOGIA, $this->tipologia);
		if ($this->isColumnModified(OppAppoggioPeer::LEGISLATURA)) $criteria->add(OppAppoggioPeer::LEGISLATURA, $this->legislatura);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppAppoggioPeer::DATABASE_NAME);

		$criteria->add(OppAppoggioPeer::ID, $this->id);
		$criteria->add(OppAppoggioPeer::CARICA_ID, $this->carica_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getId();

		$pks[1] = $this->getCaricaId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setId($keys[0]);

		$this->setCaricaId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setAka($this->aka);

		$copyObj->setTipologia($this->tipologia);

		$copyObj->setLegislatura($this->legislatura);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
		$copyObj->setCaricaId(NULL); 
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
			self::$peer = new OppAppoggioPeer();
		}
		return self::$peer;
	}

	
	public function setOppCarica($v)
	{


		if ($v === null) {
			$this->setCaricaId(NULL);
		} else {
			$this->setCaricaId($v->getId());
		}


		$this->aOppCarica = $v;
	}


	
	public function getOppCarica($con = null)
	{
				include_once 'lib/model/om/BaseOppCaricaPeer.php';

		if ($this->aOppCarica === null && ($this->carica_id !== null)) {

			$this->aOppCarica = OppCaricaPeer::retrieveByPK($this->carica_id, $con);

			
		}
		return $this->aOppCarica;
	}

} 