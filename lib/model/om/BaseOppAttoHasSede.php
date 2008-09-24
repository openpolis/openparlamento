<?php


abstract class BaseOppAttoHasSede extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $atto_id;


	
	protected $sede_id;


	
	protected $tipo;

	
	protected $aOppAtto;

	
	protected $aOppSede;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getAttoId()
	{

		return $this->atto_id;
	}

	
	public function getSedeId()
	{

		return $this->sede_id;
	}

	
	public function getTipo()
	{

		return $this->tipo;
	}

	
	public function setAttoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->atto_id !== $v) {
			$this->atto_id = $v;
			$this->modifiedColumns[] = OppAttoHasSedePeer::ATTO_ID;
		}

		if ($this->aOppAtto !== null && $this->aOppAtto->getId() !== $v) {
			$this->aOppAtto = null;
		}

	} 
	
	public function setSedeId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->sede_id !== $v) {
			$this->sede_id = $v;
			$this->modifiedColumns[] = OppAttoHasSedePeer::SEDE_ID;
		}

		if ($this->aOppSede !== null && $this->aOppSede->getId() !== $v) {
			$this->aOppSede = null;
		}

	} 
	
	public function setTipo($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->tipo !== $v) {
			$this->tipo = $v;
			$this->modifiedColumns[] = OppAttoHasSedePeer::TIPO;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->atto_id = $rs->getInt($startcol + 0);

			$this->sede_id = $rs->getInt($startcol + 1);

			$this->tipo = $rs->getString($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppAttoHasSede object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppAttoHasSedePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppAttoHasSedePeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppAttoHasSedePeer::DATABASE_NAME);
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


												
			if ($this->aOppAtto !== null) {
				if ($this->aOppAtto->isModified()) {
					$affectedRows += $this->aOppAtto->save($con);
				}
				$this->setOppAtto($this->aOppAtto);
			}

			if ($this->aOppSede !== null) {
				if ($this->aOppSede->isModified()) {
					$affectedRows += $this->aOppSede->save($con);
				}
				$this->setOppSede($this->aOppSede);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppAttoHasSedePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += OppAttoHasSedePeer::doUpdate($this, $con);
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


												
			if ($this->aOppAtto !== null) {
				if (!$this->aOppAtto->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppAtto->getValidationFailures());
				}
			}

			if ($this->aOppSede !== null) {
				if (!$this->aOppSede->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppSede->getValidationFailures());
				}
			}


			if (($retval = OppAttoHasSedePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppAttoHasSedePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getAttoId();
				break;
			case 1:
				return $this->getSedeId();
				break;
			case 2:
				return $this->getTipo();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppAttoHasSedePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getAttoId(),
			$keys[1] => $this->getSedeId(),
			$keys[2] => $this->getTipo(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppAttoHasSedePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setAttoId($value);
				break;
			case 1:
				$this->setSedeId($value);
				break;
			case 2:
				$this->setTipo($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppAttoHasSedePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setAttoId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setSedeId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTipo($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppAttoHasSedePeer::DATABASE_NAME);

		if ($this->isColumnModified(OppAttoHasSedePeer::ATTO_ID)) $criteria->add(OppAttoHasSedePeer::ATTO_ID, $this->atto_id);
		if ($this->isColumnModified(OppAttoHasSedePeer::SEDE_ID)) $criteria->add(OppAttoHasSedePeer::SEDE_ID, $this->sede_id);
		if ($this->isColumnModified(OppAttoHasSedePeer::TIPO)) $criteria->add(OppAttoHasSedePeer::TIPO, $this->tipo);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppAttoHasSedePeer::DATABASE_NAME);

		$criteria->add(OppAttoHasSedePeer::ATTO_ID, $this->atto_id);
		$criteria->add(OppAttoHasSedePeer::SEDE_ID, $this->sede_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getAttoId();

		$pks[1] = $this->getSedeId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setAttoId($keys[0]);

		$this->setSedeId($keys[1]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTipo($this->tipo);


		$copyObj->setNew(true);

		$copyObj->setAttoId(NULL); 
		$copyObj->setSedeId(NULL); 
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
			self::$peer = new OppAttoHasSedePeer();
		}
		return self::$peer;
	}

	
	public function setOppAtto($v)
	{


		if ($v === null) {
			$this->setAttoId(NULL);
		} else {
			$this->setAttoId($v->getId());
		}


		$this->aOppAtto = $v;
	}


	
	public function getOppAtto($con = null)
	{
				include_once 'lib/model/om/BaseOppAttoPeer.php';

		if ($this->aOppAtto === null && ($this->atto_id !== null)) {

			$this->aOppAtto = OppAttoPeer::retrieveByPK($this->atto_id, $con);

			
		}
		return $this->aOppAtto;
	}

	
	public function setOppSede($v)
	{


		if ($v === null) {
			$this->setSedeId(NULL);
		} else {
			$this->setSedeId($v->getId());
		}


		$this->aOppSede = $v;
	}


	
	public function getOppSede($con = null)
	{
				include_once 'lib/model/om/BaseOppSedePeer.php';

		if ($this->aOppSede === null && ($this->sede_id !== null)) {

			$this->aOppSede = OppSedePeer::retrieveByPK($this->sede_id, $con);

			
		}
		return $this->aOppSede;
	}

} 