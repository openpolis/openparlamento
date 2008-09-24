<?php


abstract class BaseOppIntervento extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $atto_id;


	
	protected $carica_id;


	
	protected $sede_id;


	
	protected $tipologia;


	
	protected $url;


	
	protected $data;


	
	protected $numero;


	
	protected $ap;

	
	protected $aOppAtto;

	
	protected $aOppCarica;

	
	protected $aOppSede;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getAttoId()
	{

		return $this->atto_id;
	}

	
	public function getCaricaId()
	{

		return $this->carica_id;
	}

	
	public function getSedeId()
	{

		return $this->sede_id;
	}

	
	public function getTipologia()
	{

		return $this->tipologia;
	}

	
	public function getUrl()
	{

		return $this->url;
	}

	
	public function getData($format = 'Y-m-d')
	{

		if ($this->data === null || $this->data === '') {
			return null;
		} elseif (!is_int($this->data)) {
						$ts = strtotime($this->data);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [data] as date/time value: " . var_export($this->data, true));
			}
		} else {
			$ts = $this->data;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getNumero()
	{

		return $this->numero;
	}

	
	public function getAp()
	{

		return $this->ap;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = OppInterventoPeer::ID;
		}

	} 
	
	public function setAttoId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->atto_id !== $v) {
			$this->atto_id = $v;
			$this->modifiedColumns[] = OppInterventoPeer::ATTO_ID;
		}

		if ($this->aOppAtto !== null && $this->aOppAtto->getId() !== $v) {
			$this->aOppAtto = null;
		}

	} 
	
	public function setCaricaId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->carica_id !== $v) {
			$this->carica_id = $v;
			$this->modifiedColumns[] = OppInterventoPeer::CARICA_ID;
		}

		if ($this->aOppCarica !== null && $this->aOppCarica->getId() !== $v) {
			$this->aOppCarica = null;
		}

	} 
	
	public function setSedeId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->sede_id !== $v) {
			$this->sede_id = $v;
			$this->modifiedColumns[] = OppInterventoPeer::SEDE_ID;
		}

		if ($this->aOppSede !== null && $this->aOppSede->getId() !== $v) {
			$this->aOppSede = null;
		}

	} 
	
	public function setTipologia($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->tipologia !== $v) {
			$this->tipologia = $v;
			$this->modifiedColumns[] = OppInterventoPeer::TIPOLOGIA;
		}

	} 
	
	public function setUrl($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->url !== $v) {
			$this->url = $v;
			$this->modifiedColumns[] = OppInterventoPeer::URL;
		}

	} 
	
	public function setData($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [data] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->data !== $ts) {
			$this->data = $ts;
			$this->modifiedColumns[] = OppInterventoPeer::DATA;
		}

	} 
	
	public function setNumero($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->numero !== $v) {
			$this->numero = $v;
			$this->modifiedColumns[] = OppInterventoPeer::NUMERO;
		}

	} 
	
	public function setAp($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ap !== $v) {
			$this->ap = $v;
			$this->modifiedColumns[] = OppInterventoPeer::AP;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->atto_id = $rs->getInt($startcol + 1);

			$this->carica_id = $rs->getInt($startcol + 2);

			$this->sede_id = $rs->getInt($startcol + 3);

			$this->tipologia = $rs->getString($startcol + 4);

			$this->url = $rs->getString($startcol + 5);

			$this->data = $rs->getDate($startcol + 6, null);

			$this->numero = $rs->getInt($startcol + 7);

			$this->ap = $rs->getInt($startcol + 8);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 9; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppIntervento object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppInterventoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppInterventoPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppInterventoPeer::DATABASE_NAME);
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

			if ($this->aOppCarica !== null) {
				if ($this->aOppCarica->isModified()) {
					$affectedRows += $this->aOppCarica->save($con);
				}
				$this->setOppCarica($this->aOppCarica);
			}

			if ($this->aOppSede !== null) {
				if ($this->aOppSede->isModified()) {
					$affectedRows += $this->aOppSede->save($con);
				}
				$this->setOppSede($this->aOppSede);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = OppInterventoPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OppInterventoPeer::doUpdate($this, $con);
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

			if ($this->aOppCarica !== null) {
				if (!$this->aOppCarica->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppCarica->getValidationFailures());
				}
			}

			if ($this->aOppSede !== null) {
				if (!$this->aOppSede->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aOppSede->getValidationFailures());
				}
			}


			if (($retval = OppInterventoPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppInterventoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getAttoId();
				break;
			case 2:
				return $this->getCaricaId();
				break;
			case 3:
				return $this->getSedeId();
				break;
			case 4:
				return $this->getTipologia();
				break;
			case 5:
				return $this->getUrl();
				break;
			case 6:
				return $this->getData();
				break;
			case 7:
				return $this->getNumero();
				break;
			case 8:
				return $this->getAp();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppInterventoPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getAttoId(),
			$keys[2] => $this->getCaricaId(),
			$keys[3] => $this->getSedeId(),
			$keys[4] => $this->getTipologia(),
			$keys[5] => $this->getUrl(),
			$keys[6] => $this->getData(),
			$keys[7] => $this->getNumero(),
			$keys[8] => $this->getAp(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppInterventoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setAttoId($value);
				break;
			case 2:
				$this->setCaricaId($value);
				break;
			case 3:
				$this->setSedeId($value);
				break;
			case 4:
				$this->setTipologia($value);
				break;
			case 5:
				$this->setUrl($value);
				break;
			case 6:
				$this->setData($value);
				break;
			case 7:
				$this->setNumero($value);
				break;
			case 8:
				$this->setAp($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppInterventoPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setAttoId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setCaricaId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSedeId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setTipologia($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setUrl($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setData($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setNumero($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setAp($arr[$keys[8]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppInterventoPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppInterventoPeer::ID)) $criteria->add(OppInterventoPeer::ID, $this->id);
		if ($this->isColumnModified(OppInterventoPeer::ATTO_ID)) $criteria->add(OppInterventoPeer::ATTO_ID, $this->atto_id);
		if ($this->isColumnModified(OppInterventoPeer::CARICA_ID)) $criteria->add(OppInterventoPeer::CARICA_ID, $this->carica_id);
		if ($this->isColumnModified(OppInterventoPeer::SEDE_ID)) $criteria->add(OppInterventoPeer::SEDE_ID, $this->sede_id);
		if ($this->isColumnModified(OppInterventoPeer::TIPOLOGIA)) $criteria->add(OppInterventoPeer::TIPOLOGIA, $this->tipologia);
		if ($this->isColumnModified(OppInterventoPeer::URL)) $criteria->add(OppInterventoPeer::URL, $this->url);
		if ($this->isColumnModified(OppInterventoPeer::DATA)) $criteria->add(OppInterventoPeer::DATA, $this->data);
		if ($this->isColumnModified(OppInterventoPeer::NUMERO)) $criteria->add(OppInterventoPeer::NUMERO, $this->numero);
		if ($this->isColumnModified(OppInterventoPeer::AP)) $criteria->add(OppInterventoPeer::AP, $this->ap);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppInterventoPeer::DATABASE_NAME);

		$criteria->add(OppInterventoPeer::ID, $this->id);
		$criteria->add(OppInterventoPeer::ATTO_ID, $this->atto_id);
		$criteria->add(OppInterventoPeer::CARICA_ID, $this->carica_id);
		$criteria->add(OppInterventoPeer::SEDE_ID, $this->sede_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		$pks = array();

		$pks[0] = $this->getId();

		$pks[1] = $this->getAttoId();

		$pks[2] = $this->getCaricaId();

		$pks[3] = $this->getSedeId();

		return $pks;
	}

	
	public function setPrimaryKey($keys)
	{

		$this->setId($keys[0]);

		$this->setAttoId($keys[1]);

		$this->setCaricaId($keys[2]);

		$this->setSedeId($keys[3]);

	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setTipologia($this->tipologia);

		$copyObj->setUrl($this->url);

		$copyObj->setData($this->data);

		$copyObj->setNumero($this->numero);

		$copyObj->setAp($this->ap);


		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
		$copyObj->setAttoId(NULL); 
		$copyObj->setCaricaId(NULL); 
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
			self::$peer = new OppInterventoPeer();
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