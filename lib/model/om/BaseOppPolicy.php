<?php


abstract class BaseOppPolicy extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $titolo;


	
	protected $descrizione;


	
	protected $provvisoria;

	
	protected $collOppPolicyHasVotaziones;

	
	protected $lastOppPolicyHasVotazioneCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getTitolo()
	{

		return $this->titolo;
	}

	
	public function getDescrizione()
	{

		return $this->descrizione;
	}

	
	public function getProvvisoria()
	{

		return $this->provvisoria;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = OppPolicyPeer::ID;
		}

	} 
	
	public function setTitolo($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->titolo !== $v) {
			$this->titolo = $v;
			$this->modifiedColumns[] = OppPolicyPeer::TITOLO;
		}

	} 
	
	public function setDescrizione($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->descrizione !== $v) {
			$this->descrizione = $v;
			$this->modifiedColumns[] = OppPolicyPeer::DESCRIZIONE;
		}

	} 
	
	public function setProvvisoria($v)
	{

		if ($this->provvisoria !== $v) {
			$this->provvisoria = $v;
			$this->modifiedColumns[] = OppPolicyPeer::PROVVISORIA;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->titolo = $rs->getString($startcol + 1);

			$this->descrizione = $rs->getString($startcol + 2);

			$this->provvisoria = $rs->getBoolean($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppPolicy object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppPolicyPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppPolicyPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppPolicyPeer::DATABASE_NAME);
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
					$pk = OppPolicyPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OppPolicyPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collOppPolicyHasVotaziones !== null) {
				foreach($this->collOppPolicyHasVotaziones as $referrerFK) {
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


			if (($retval = OppPolicyPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOppPolicyHasVotaziones !== null) {
					foreach($this->collOppPolicyHasVotaziones as $referrerFK) {
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
		$pos = OppPolicyPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getTitolo();
				break;
			case 2:
				return $this->getDescrizione();
				break;
			case 3:
				return $this->getProvvisoria();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppPolicyPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTitolo(),
			$keys[2] => $this->getDescrizione(),
			$keys[3] => $this->getProvvisoria(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppPolicyPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setTitolo($value);
				break;
			case 2:
				$this->setDescrizione($value);
				break;
			case 3:
				$this->setProvvisoria($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppPolicyPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTitolo($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDescrizione($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setProvvisoria($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppPolicyPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppPolicyPeer::ID)) $criteria->add(OppPolicyPeer::ID, $this->id);
		if ($this->isColumnModified(OppPolicyPeer::TITOLO)) $criteria->add(OppPolicyPeer::TITOLO, $this->titolo);
		if ($this->isColumnModified(OppPolicyPeer::DESCRIZIONE)) $criteria->add(OppPolicyPeer::DESCRIZIONE, $this->descrizione);
		if ($this->isColumnModified(OppPolicyPeer::PROVVISORIA)) $criteria->add(OppPolicyPeer::PROVVISORIA, $this->provvisoria);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppPolicyPeer::DATABASE_NAME);

		$criteria->add(OppPolicyPeer::ID, $this->id);

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

		$copyObj->setTitolo($this->titolo);

		$copyObj->setDescrizione($this->descrizione);

		$copyObj->setProvvisoria($this->provvisoria);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getOppPolicyHasVotaziones() as $relObj) {
				$copyObj->addOppPolicyHasVotazione($relObj->copy($deepCopy));
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
			self::$peer = new OppPolicyPeer();
		}
		return self::$peer;
	}

	
	public function initOppPolicyHasVotaziones()
	{
		if ($this->collOppPolicyHasVotaziones === null) {
			$this->collOppPolicyHasVotaziones = array();
		}
	}

	
	public function getOppPolicyHasVotaziones($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppPolicyHasVotazionePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppPolicyHasVotaziones === null) {
			if ($this->isNew()) {
			   $this->collOppPolicyHasVotaziones = array();
			} else {

				$criteria->add(OppPolicyHasVotazionePeer::POLICY_ID, $this->getId());

				OppPolicyHasVotazionePeer::addSelectColumns($criteria);
				$this->collOppPolicyHasVotaziones = OppPolicyHasVotazionePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppPolicyHasVotazionePeer::POLICY_ID, $this->getId());

				OppPolicyHasVotazionePeer::addSelectColumns($criteria);
				if (!isset($this->lastOppPolicyHasVotazioneCriteria) || !$this->lastOppPolicyHasVotazioneCriteria->equals($criteria)) {
					$this->collOppPolicyHasVotaziones = OppPolicyHasVotazionePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppPolicyHasVotazioneCriteria = $criteria;
		return $this->collOppPolicyHasVotaziones;
	}

	
	public function countOppPolicyHasVotaziones($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppPolicyHasVotazionePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppPolicyHasVotazionePeer::POLICY_ID, $this->getId());

		return OppPolicyHasVotazionePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppPolicyHasVotazione(OppPolicyHasVotazione $l)
	{
		$this->collOppPolicyHasVotaziones[] = $l;
		$l->setOppPolicy($this);
	}


	
	public function getOppPolicyHasVotazionesJoinOppVotazione($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppPolicyHasVotazionePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppPolicyHasVotaziones === null) {
			if ($this->isNew()) {
				$this->collOppPolicyHasVotaziones = array();
			} else {

				$criteria->add(OppPolicyHasVotazionePeer::POLICY_ID, $this->getId());

				$this->collOppPolicyHasVotaziones = OppPolicyHasVotazionePeer::doSelectJoinOppVotazione($criteria, $con);
			}
		} else {
									
			$criteria->add(OppPolicyHasVotazionePeer::POLICY_ID, $this->getId());

			if (!isset($this->lastOppPolicyHasVotazioneCriteria) || !$this->lastOppPolicyHasVotazioneCriteria->equals($criteria)) {
				$this->collOppPolicyHasVotaziones = OppPolicyHasVotazionePeer::doSelectJoinOppVotazione($criteria, $con);
			}
		}
		$this->lastOppPolicyHasVotazioneCriteria = $criteria;

		return $this->collOppPolicyHasVotaziones;
	}

} 