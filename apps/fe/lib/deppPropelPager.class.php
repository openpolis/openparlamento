<?php
/**
 * Classe che estende la sfPropelPager, permettendo di specificare, nel metodo init(),
 * un criterio per il count differente dal criterio generale
 *
 * @package default
 * @author Guglielmo Celata
 */
class deppPropelPager extends sfPropelPager
{
  public function init($cForCount = null)
  {
    $hasMaxRecordLimit = ($this->getMaxRecordLimit() !== false);
    $maxRecordLimit = $this->getMaxRecordLimit();

    if (is_null($cForCount)) $cForCount = clone $this->getCriteria();
    $cForCount->setOffset(0);
    $cForCount->setLimit(0);
    $cForCount->clearGroupByColumns();

    // require the model class (because autoloading can crash under some conditions)
    if (!$classPath = sfCore::getClassPath($this->getClassPeer()))
    {
      throw new sfException(sprintf('Unable to find path for class "%s".', $this->getClassPeer()));
    }
    require_once($classPath);
    $count = call_user_func(array($this->getClassPeer(), $this->getPeerCountMethod()), $cForCount);

    $this->setNbResults($hasMaxRecordLimit ? min($count, $maxRecordLimit) : $count);

    $c = $this->getCriteria();
    $c->setOffset(0);
    $c->setLimit(0);

    if (($this->getPage() == 0 || $this->getMaxPerPage() == 0))
    {
      $this->setLastPage(0);
    }
    else
    {
      $this->setLastPage(ceil($this->getNbResults() / $this->getMaxPerPage()));

      $offset = ($this->getPage() - 1) * $this->getMaxPerPage();
      $c->setOffset($offset);

      if ($hasMaxRecordLimit)
      {
        $maxRecordLimit = $maxRecordLimit - $offset;
        if ($maxRecordLimit > $this->getMaxPerPage())
        {
          $c->setLimit($this->getMaxPerPage());
        }
        else
        {
          $c->setLimit($maxRecordLimit);
        }
      }
      else
      {
        $c->setLimit($this->getMaxPerPage());
      }
    }
  }
}