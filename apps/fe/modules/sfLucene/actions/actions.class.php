<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(SF_ROOT_DIR . '/plugins/sfLucenePlugin/modules/sfLucene/lib/BasesfLuceneActions.class.php');

/**
 * @package    sfLucenePlugin
 * @subpackage Module
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */
class sfLuceneActions extends BasesfLuceneActions
{
  /**
  * Executes a constrained search action.  
  * The search query inserted by the user is constrained by the fields_constraints request parameter
  * This allows to constrain the search, specifying filters (date, section, types of objects)
  * Categories 
  */
  public function executeAttiSearch()
  {
    // determine if the user pressed the "Advanced"  button
    if ($this->getRequestParameter('commit') == $this->translate('Advanced'))
    {
      // user did, so redirect to advanced search
      $this->redirect($this->getModuleName() . '/advancedSearch');
    }

    $this->advanced_enabled = sfConfig::get('sf_lucene_interface_advanced', true);

    $query = $this->getRequestParameter('query');
    $this->type = $this->getRequestParameter('type', 'disegni');

    $titles = array ('disegni' => 'nei disegni di legge',
                     'decreti' => 'nei decreti legge',
                     'decrleg' => 'nei decreti legislativi',
                     'nonleg'  => 'negli atti non legislativi');
    $this->title = $titles[$this->type];    

    $this->pages_names = array('disegni' => 'Disegni di legge',
                               'decreti' => 'Decreti legge',
                               'decrleg' => 'Decreti Legislativi',
                               'nonleg'  => 'Atti Non Legislativi');

    $this->pages_routes = array('disegni' => '@attiDisegni',
                                'decreti' => '@attiDecretiLegge',
                                'decrleg' => '@attiDecretiLegislativi',
                                'nonleg'  => '@attiNonLegislativi');

    
    
    // did user enter a query?
    if ($query)
    {
      // query is passed back to the view, to fill the input field
      $this->query = $query;

      // constraints on the query are built from the type
      $fields_constraints = array('sfl_model' => 'OppAtto', 'tipoatto' => $this->type);
      
      // get query results
      $pager = $this->getResults($query, $fields_constraints);

      $num = $pager->getNbResults();

      // were any results returned?
      if ($num > 0)
      {
        // display results
        $this->configurePager($pager);

        $this->num = $num;
        $this->pager = $pager;

        $this->setTitle('Openpolis - Ricerca per <' . $query . '> ' . $this->title);

        return 'Results';
      }
      else
      {
        // display error
        $this->setTitle('Openpolis - Ricerca per <' . $query . '> ' . $this->title);

        return 'NoResults';
      }
    }
    else
    {
      // on direct visits, redirect to atti lists
      $this->redirect($this->pages_routes[$this->type]);
    }
  }

  /**
   * a modified override for the getResults method, that accept an array of fields constraints
   *
   * @param string $querystring 
   * @param string $fields_constraints  a hash of the form $field => $constraint ('sfl_model' => 'OppAtto')
   * @param string $category 
   * @return void
   * @author Guglielmo Celata
   */
  protected function getResults($querystring, $fields_constraints = array(), $category = null)
  {
    $query = new sfLuceneCriteria($this->getLuceneInstance());
    $query->addSane($querystring);

    if ($fields_constraints == '') $fields_constraints = array();
    foreach ($fields_constraints as $field => $constraint)
    {
      $query->addField($constraint, $field);      
    }

    # query debug
    # sfLogger::getInstance()->info('xxx' . $query->getQuery());
    
    
    if (sfConfig::get('app_lucene_categories', true) && $category)
    {
      $query->add('sfl_category: ' . $category);
    }

    return new sfLucenePager( $this->getLuceneInstance()->friendlyFind($query) );
  }
  
}
