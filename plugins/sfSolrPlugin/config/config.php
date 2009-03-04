<?php
/*
 * This file is part of the sfSolrPlugin package
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


/**
  * @package sfSolrPlugin
  * @subpackage Configuration
  * @author Guglielmo Celata <g.celata@depp.it>
  */

// let PHP find the Solr API
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'SolrPhpClient');

// setup default routes
if (sfConfig::get('app_solr_routes', true) && in_array('sfSolr', sfConfig::get('sf_enabled_modules', array())))
{
  $r = sfRouting::getInstance();

  $r->prependRoute('sf_solr_search', '/search', array('module' => 'sfSolr', 'action' => 'search'));
  $r->prependRoute('sf_solr_search_results', '/search/results/:query/*', 
                   array('module' => 'sfSolr', 'action' => 'search'), 
                   array('page' => '\d+'));

  if (sfConfig::get('app_solr_advanced', true))
  {
    $r->prependRoute('sf_solr_search_advanced', '/search/advanced', 
                     array('module' => 'sfSolr', 'action' => 'advancedSearch'));
  }

}
