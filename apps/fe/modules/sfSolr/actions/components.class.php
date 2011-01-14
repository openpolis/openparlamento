<?php
/*
 * This file is part of the sfSolrPlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


require_once(SF_ROOT_DIR . '/plugins/sfSolrPlugin/modules/sfSolr/lib/BasesfSolrComponents.class.php');

/**
 * @package    sfSolrPlugin
 * @subpackage Module
 * @author     Guglielmo Celata <g.celata@depp.it>
 */
class sfSolrComponents extends BasesfSolrComponents
{
  public function executeAddAlert()
  {
    $this->type_filters_label = OppAlertTermPeer::get_filters_labels($this->type_filters);
  }
}
