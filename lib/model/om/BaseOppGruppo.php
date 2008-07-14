<?php


abstract class BaseOppGruppo extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $nome;


	
	protected $acronimo;

	
	protected $collOppCaricaHasGruppos;

	
	protected $lastOppCaricaHasGruppoCriteria = null;

	
	protected $collOppLegislaturaHasGruppos;

	
	protected $lastOppLegislaturaHasGruppoCriteria = null;

	
	protected $collOppVotazioneHasGruppos;

	
	protected $lastOppVotazioneHasGruppoCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getNome()
	{

		return $this->nome;
	}

	
	public function getAcronimo()
	{

		return $this->acronimo;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = OppGruppoPeer::ID;
		}

	} 
	
	public function setNome($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->nome !== $v) {
			$this->nome = $v;
			$this->modifiedColumns[] = OppGruppoPeer::NOME;
		}

	} 
	
	public function setAcronimo($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->acronimo !== $v) {
			$this->acronimo = $v;
			$this->modifiedColumns[] = OppGruppoPeer::ACRONIMO;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->nome = $rs->getString($startcol + 1);

			$this->acronimo = $rs->getString($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating OppGruppo object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(OppGruppoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			OppGruppoPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(OppGruppoPeer::DATABASE_NAME);
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
					$pk = OppGruppoPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += OppGruppoPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collOppCaricaHasGruppos !== null) {
				foreach($this->collOppCaricaHasGruppos as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOppLegislaturaHasGruppos !== null) {
				foreach($this->collOppLegislaturaHasGruppos as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collOppVotazioneHasGruppos !== null) {
				foreach($this->collOppVotazioneHasGruppos as $referrerFK) {
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


			if (($retval = OppGruppoPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collOppCaricaHasGruppos !== null) {
					foreach($this->collOppCaricaHasGruppos as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOppLegislaturaHasGruppos !== null) {
					foreach($this->collOppLegislaturaHasGruppos as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collOppVotazioneHasGruppos !== null) {
					foreach($this->collOppVotazioneHasGruppos as $referrerFK) {
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
		$pos = OppGruppoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getNome();
				break;
			case 2:
				return $this->getAcronimo();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppGruppoPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getNome(),
			$keys[2] => $this->getAcronimo(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = OppGruppoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setNome($value);
				break;
			case 2:
				$this->setAcronimo($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = OppGruppoPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setNome($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setAcronimo($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(OppGruppoPeer::DATABASE_NAME);

		if ($this->isColumnModified(OppGruppoPeer::ID)) $criteria->add(OppGruppoPeer::ID, $this->id);
		if ($this->isColumnModified(OppGruppoPeer::NOME)) $criteria->add(OppGruppoPeer::NOME, $this->nome);
		if ($this->isColumnModified(OppGruppoPeer::ACRONIMO)) $criteria->add(OppGruppoPeer::ACRONIMO, $this->acronimo);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(OppGruppoPeer::DATABASE_NAME);

		$criteria->add(OppGruppoPeer::ID, $this->id);

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

		$copyObj->setNome($this->nome);

		$copyObj->setAcronimo($this->acronimo);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getOppCaricaHasGruppos() as $relObj) {
				$copyObj->addOppCaricaHasGruppo($relObj->copy($deepCopy));
			}

			foreach($this->getOppLegislaturaHasGruppos() as $relObj) {
				$copyObj->addOppLegislaturaHasGruppo($relObj->copy($deepCopy));
			}

			foreach($this->getOppVotazioneHasGruppos() as $relObj) {
				$copyObj->addOppVotazioneHasGruppo($relObj->copy($deepCopy));
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
			self::$peer = new OppGruppoPeer();
		}
		return self::$peer;
	}

	
	public function initOppCaricaHasGruppos()
	{
		if ($this->collOppCaricaHasGruppos === null) {
			$this->collOppCaricaHasGruppos = array();
		}
	}

	
	public function getOppCaricaHasGruppos($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppCaricaHasGruppoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppCaricaHasGruppos === null) {
			if ($this->isNew()) {
			   $this->collOppCaricaHasGruppos = array();
			} else {

				$criteria->add(OppCaricaHasGruppoPeer::GRUPPO_ID, $this->getId());

				OppCaricaHasGruppoPeer::addSelectColumns($criteria);
				$this->collOppCaricaHasGruppos = OppCaricaHasGruppoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppCaricaHasGruppoPeer::GRUPPO_ID, $this->getId());

				OppCaricaHasGruppoPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppCaricaHasGruppoCriteria) || !$this->lastOppCaricaHasGruppoCriteria->equals($criteria)) {
					$this->collOppCaricaHasGruppos = OppCaricaHasGruppoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppCaricaHasGruppoCriteria = $criteria;
		return $this->collOppCaricaHasGruppos;
	}

	
	public function countOppCaricaHasGruppos($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppCaricaHasGruppoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppCaricaHasGruppoPeer::GRUPPO_ID, $this->getId());

		return OppCaricaHasGruppoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppCaricaHasGruppo(OppCaricaHasGruppo $l)
	{
		$this->collOppCaricaHasGruppos[] = $l;
		$l->setOppGruppo($this);
	}


	
	public function getOppCaricaHasGrupposJoinOppCarica($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppCaricaHasGruppoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppCaricaHasGruppos === null) {
			if ($this->isNew()) {
				$this->collOppCaricaHasGruppos = array();
			} else {

				$criteria->add(OppCaricaHasGruppoPeer::GRUPPO_ID, $this->getId());

				$this->collOppCaricaHasGruppos = OppCaricaHasGruppoPeer::doSelectJoinOppCarica($criteria, $con);
			}
		} else {
									
			$criteria->add(OppCaricaHasGruppoPeer::GRUPPO_ID, $this->getId());

			if (!isset($this->lastOppCaricaHasGruppoCriteria) || !$this->lastOppCaricaHasGruppoCriteria->equals($criteria)) {
				$this->collOppCaricaHasGruppos = OppCaricaHasGruppoPeer::doSelectJoinOppCarica($criteria, $con);
			}
		}
		$this->lastOppCaricaHasGruppoCriteria = $criteria;

		return $this->collOppCaricaHasGruppos;
	}

	
	public function initOppLegislaturaHasGruppos()
	{
		if ($this->collOppLegislaturaHasGruppos === null) {
			$this->collOppLegislaturaHasGruppos = array();
		}
	}

	
	public function getOppLegislaturaHasGruppos($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppLegislaturaHasGruppoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppLegislaturaHasGruppos === null) {
			if ($this->isNew()) {
			   $this->collOppLegislaturaHasGruppos = array();
			} else {

				$criteria->add(OppLegislaturaHasGruppoPeer::GRUPPO_ID, $this->getId());

				OppLegislaturaHasGruppoPeer::addSelectColumns($criteria);
				$this->collOppLegislaturaHasGruppos = OppLegislaturaHasGruppoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppLegislaturaHasGruppoPeer::GRUPPO_ID, $this->getId());

				OppLegislaturaHasGruppoPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppLegislaturaHasGruppoCriteria) || !$this->lastOppLegislaturaHasGruppoCriteria->equals($criteria)) {
					$this->collOppLegislaturaHasGruppos = OppLegislaturaHasGruppoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppLegislaturaHasGruppoCriteria = $criteria;
		return $this->collOppLegislaturaHasGruppos;
	}

	
	public function countOppLegislaturaHasGruppos($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppLegislaturaHasGruppoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppLegislaturaHasGruppoPeer::GRUPPO_ID, $this->getId());

		return OppLegislaturaHasGruppoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppLegislaturaHasGruppo(OppLegislaturaHasGruppo $l)
	{
		$this->collOppLegislaturaHasGruppos[] = $l;
		$l->setOppGruppo($this);
	}

	
	public function initOppVotazioneHasGruppos()
	{
		if ($this->collOppVotazioneHasGruppos === null) {
			$this->collOppVotazioneHasGruppos = array();
		}
	}

	
	public function getOppVotazioneHasGruppos($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppVotazioneHasGruppoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppVotazioneHasGruppos === null) {
			if ($this->isNew()) {
			   $this->collOppVotazioneHasGruppos = array();
			} else {

				$criteria->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, $this->getId());

				OppVotazioneHasGruppoPeer::addSelectColumns($criteria);
				$this->collOppVotazioneHasGruppos = OppVotazioneHasGruppoPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, $this->getId());

				OppVotazioneHasGruppoPeer::addSelectColumns($criteria);
				if (!isset($this->lastOppVotazioneHasGruppoCriteria) || !$this->lastOppVotazioneHasGruppoCriteria->equals($criteria)) {
					$this->collOppVotazioneHasGruppos = OppVotazioneHasGruppoPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastOppVotazioneHasGruppoCriteria = $criteria;
		return $this->collOppVotazioneHasGruppos;
	}

	
	public function countOppVotazioneHasGruppos($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseOppVotazioneHasGruppoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, $this->getId());

		return OppVotazioneHasGruppoPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addOppVotazioneHasGruppo(OppVotazioneHasGruppo $l)
	{
		$this->collOppVotazioneHasGruppos[] = $l;
		$l->setOppGruppo($this);
	}


	
	public function getOppVotazioneHasGrupposJoinOppVotazione($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseOppVotazioneHasGruppoPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collOppVotazioneHasGruppos === null) {
			if ($this->isNew()) {
				$this->collOppVotazioneHasGruppos = array();
			} else {

				$criteria->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, $this->getId());

				$this->collOppVotazioneHasGruppos = OppVotazioneHasGruppoPeer::doSelectJoinOppVotazione($criteria, $con);
			}
		} else {
									
			$criteria->add(OppVotazioneHasGruppoPeer::GRUPPO_ID, $this->getId());

			if (!isset($this->lastOppVotazioneHasGruppoCriteria) || !$this->lastOppVotazioneHasGruppoCriteria->equals($criteria)) {
				$this->collOppVotazioneHasGruppos = OppVotazioneHasGruppoPeer::doSelectJoinOppVotazione($criteria, $con);
			}
		}
		$this->lastOppVotazioneHasGruppoCriteria = $criteria;

		return $this->collOppVotazioneHasGruppos;
	}

} 