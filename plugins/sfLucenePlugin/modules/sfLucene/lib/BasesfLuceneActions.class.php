<?php
/*
 * This file is part of the sfLucenePLugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Base class for sfLucene actions.
 *
 * @package    sfLucenePlugin
 * @subpackage Module
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */
abstract class BasesfLuceneActions extends sfActions
{
  /**
   * For compatiability with default routing rules.
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

    $this->advanced_enabled = sfConfig::get('sf_lucene_interface_advanced', true);
    $this->categories_enabled = sfConfig::get('sf_lucene_interface_categories', true);

    $query = $this->getRequestParameter('query');

    // did user enter a query?
    if ($query)
    {
      $this->category = $this->getRequestParameter('category', null);

      // get results
      $pager = $this->getResults($query, $this->category);

      $num = $pager->getNbResults();

      // were any results returned?
      if ($num > 0)
      {
        // display results
        $this->configurePager($pager);

        $this->num = $num;
        $this->pager = $pager;
        $this->query = $query;

        $this->setTitleNumResults($pager);

        return 'Results';
      }
      else
      {
        // display error
        $this->setTitleI18n('No Results Found');

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
    $this->forward404Unless( sfConfig::get('app_lucene_advanced', true) == true, 'advanced support is disabled' );

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

      // build the has pharse part
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
  protected function getResults($querystring, $category = null)
  {
    $query = new sfLuceneCriteria($this->getLuceneInstance());
    $query->addSane($querystring);

    if (sfConfig::get('app_lucene_categories', true) && $category)
    {
      $query->add('sfl_category: ' . $category);
    }

    return new sfLucenePager( $this->getLuceneInstance()->friendlyFind($query) );
  }

  /**
   * Returns an instance of sfLucene configured for this environment.
   */
  protected function getLuceneInstance()
  {
    return sfLuceneToolkit::getApplicationInstance();
  }

  /**
  * Configures the pager according to the request parameters.
  */
  protected function configurePager($pager)
  {
    $page = (int) ($this->getRequestParameter('page', 1));

    $pager->setMaxPerPage(sfConfig::get('app_lucene_per_page', 10));

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

    return $pager;
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
