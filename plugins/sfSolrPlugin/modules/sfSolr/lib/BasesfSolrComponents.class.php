<?php
/*
 * This file is part of the sfSolrPlugin package
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    sfSolrPlugin
 * @subpackage Module
 * @author     Guglielmo Celata <g.celata@depp.it>
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */
abstract class BasesfSolrComponents extends sfComponents
{
  public function executeControls()
  {
    $this->query = $this->getRequestParameter('query');
  }

  public function executePublicControls()
  {
    $this->query = $this->getRequestParameter('query');
  }

  public function executePagerNavigation()
  {
    $radius = isset($this->radius) ? $this->radius : 5;

    $this->links = $this->pager->getLinks($radius);

    $this->query = $this->getRequestParameter('query');
  }

}
