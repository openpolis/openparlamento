<?php
/*
 * This file is part of the sfSolrPlugin package
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Base class for sfSolr actions.
 *
 * @package    sfSolrPlugin
 * @subpackage Module
 * @author     Guglielmo Celata <g.celata@depp.it>
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */
abstract class BasesfSolrActions extends sfActions
{
  /**
   * For compatibility with default routing rules.
   */
  public function executeIndex()
  {
    $this->forward($this->getModuleName(), 'search');
  }

  /**
  * Executes the search action.  If there is a search query present in the request
  * parameters, then a search is executed and uses a paged result.  If not, then
  * the search box is displayed to prompt the user to enter controls.
  */
  public function executeSearch()
  {
    // determine if the user pressed the "Advanced"  button
    if ($this->getRequestParameter('commit') == $this->translate('Advanced'))
    {
      // user did, so redirect to advanced search
      $this->redirect($this->getModuleName() . '/advancedSearch');
    }

    $this->advanced_enabled = sfConfig::get('sf_solr_interface_advanced', true);

    $query = $this->getRequestParameter('query');
    $page = (int) $this->getRequestParameter('page', 1);

    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));

    // did user enter a query?
    if ($query)
    {
      
      $pager = new sfSolrPager();
      $pager->setMaxPerPage($itemsperpage);

      $offset = ($page - 1) * $pager->getMaxPerPage();
      
      $pager->setSearch($this->getSolrInstance());
      $pager->setResults($this->getResults($query, $offset, $pager->getMaxPerPage()));
      
      $num = $pager->getNbResults();

      // were any results returned?
      if ($num > 0)
      {
        $this->safelySetPagerPage($pager, $page);

        $this->num = $num;
        $pager_results = $pager->getResults();
        
        $this->qTime = $pager_results->getQTime();
        $this->start = $pager_results->getStart();
        $this->rows = min($pager_results->getRows(), $num);
        $this->pager = $pager;
        $this->query = $query;

        $this->setTitle($query);

        return 'Results';
      }
      else
      {
        // display error
        $this->setTitle($query);                                                                                      
        return 'NoResults';
      }
    }
    else
    {
      // display search controls
      $this->setTitleI18n('Search');
      return 'Controls';
    }
  }

  /**
  * This action is a friendly advanced search interface.  It lets the
  * user use a form to control some of the advanced query syntaxes.
  */
  public function executeAdvancedSearch()
  {
    // disable this action if advanced searching is disabled.
    $this->forward404Unless( sfConfig::get('app_solr_advanced', true) == true, 'advanced support is disabled' );

    // determine if the "Basic" button was clicked
    if ($this->getRequestParameter('commit') == $this->translate('Basic'))
    {
      $this->redirect($this->getModuleName() . '/search');
    }

    // did the user submit the form?
    if ($this->getRequestParameter('mode') == 'search')
    {
      // base quey
      $query = $this->getRequestParameter('keywords');

      // build the must have part
      $musthave = preg_split('/ +/', $this->getRequestParameter('musthave'), -1, PREG_SPLIT_NO_EMPTY);

      if (count($musthave))
      {
        $query .= ' +' . implode($musthave, ' +');
      }

      // build the must not have
      $mustnothave = preg_split('/ +/', $this->getRequestParameter('mustnothave'), -1, PREG_SPLIT_NO_EMPTY);

      if (count($mustnothave))
      {
        $query .= ' -' . implode($mustnothave, ' -');
      }

      // build the has phrase part
      if ($this->getRequestParameter('hasphrase') != '')
      {
        $query .= ' "' . str_replace('"', '', $this->getRequestParameter('hasphrase')) . '"';
      }

      $query = trim($query);

      // is there a query?
      if ($query)
      {
        // yes, so search

        $this->getRequest()->setParameter('query', $query);

        $this->forward($this->getModuleName(), 'search');
      }
    }

    $this->setTitleI18n('Advanced Search');

    return 'Controls';
  }

  /**
  * Wrapper function for getting the results.
  */
  protected function getResults($querystring)
  {
    return new sfSolrPager( $this->getSolrInstance()->search($query) );
  }

  /**
   * Returns an instance of sfSolr configured for this environment.
   */
  protected function getSolrInstance()
  {
    return sfSolr::getInstance();
  }

  /**
  * Set pager page, checking that boundaries are not crossed
  */
  protected function safelySetPagerPage($pager, $page)
  {
    if ($page < 1)
    {
      $pager->setPage(1);
    }
    elseif ($page > $pager->getLastPage())
    {
      $pager->setPage($pager->getLastPage());
    }
    else
    {
      $pager->setPage($page);
    }

  }

  /**
  * Sets the title depending on the number of results.
  */
  protected function setTitleNumResults($pager)
  {
    $first = $pager->getFirstIndice();
    $last = $pager->getLastIndice();

    if ($first < $last)
    {
      $title = 'Results %first% to %last%';

      if ($pager->haveToPaginate())
      {
        $title .= ' of %total%';
      }
    }
    else
    {
      $title = 'Results %first% of %total%';
    }

    $this->setTitleI18n($title, array('%first%' => $first, '%last%' => $last, '%total%' => $pager->getNbResults()));
  }

  /**
  * Wrapper function for setting the title.  Overload to append or prepend
  * something to the title specific to your application.
  */
  protected function setTitle($title)
  {
    $this->getResponse()->setTitle($title);
  }

  protected function setTitleI18n($title, $args = array(), $ns = 'messages')
  {
    $this->setTitle( $this->translate($title, $args, $ns) );
  }

  protected function translate($text, $args = array(), $ns = 'messages')
  {
    sfLoader::loadHelpers('I18N');

    return __($text, $args, $ns);
  }
}
