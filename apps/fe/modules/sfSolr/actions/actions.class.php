<?php
/*
 * This file is part of the sfSolrPlugin package
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
require_once(SF_ROOT_DIR . '/plugins/sfSolrPlugin/modules/sfSolr/lib/BasesfSolrActions.class.php');

/**
 * @package    sfSolrPlugin
 * @subpackage Module
 * @author     Guglielmo Celata <g.celata@depp.it>
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */
class sfSolrActions extends BasesfSolrActions
{
  
  /**
   * Executes constrained search actions for Atti, Votazioni and Parlamentari.  
   * The search query inserted by the user is constrained by the fields_constraints request parameter
   * This allows to constrain the search, specifying filters (date, section, types of objects)
   * Categories 
   */
  
  
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
    
    if ($this->hasRequestParameter('date_filter')) {
      $date_filter = $this->getRequestParameter('date_filter', '');
      // $this->getUser()->setAttribute('search_date_filter', $this->getRequestParameter('date_filter'));
    }
    // $date_filter = $this->getUser()->getAttribute('search_date_filter', '');

    // did user enter a query?
    if ($query)
    {
      sfContext::getInstance()->getLogger()->info('{sfSolr} query: ' . $query);

      sfConfig::set('solr_query_debug_level', 1);
      
      $fields_constraints = array();
      
      if ($date_filter != '') {
        switch ($date_filter) {
          case 'week':
            $fields_constraints['created_at_dt'] = "[NOW-7DAYS/SECOND TO NOW]";
            break;

          case 'month':
            $fields_constraints['created_at_dt'] = "[NOW-1MONTH/SECOND TO NOW]";
            break;

          case 'semester':
            $fields_constraints['created_at_dt'] = "[NOW-6MONTHS/SECOND TO NOW]";
            break;
          
          case 'year':
            $fields_constraints['created_at_dt'] = "[NOW-1YEAR/SECOND TO NOW]";
            break;
        }
      }
 
      $pager = new sfSolrPager();
      $pager->setMaxPerPage($itemsperpage);

      $offset = ($page - 1) * $pager->getMaxPerPage();
 
      $pager->setSearch($this->getSolrInstance());
 
      try {
        $pager->setResults($this->getResults($query, $offset, $pager->getMaxPerPage(), $fields_constraints));      
      } catch (sfSolrException $e) {
        $this->setTitle($query);
        $this->query = $query;
        return 'NoResults';
      }
 
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
        $this->query = $query;
        $this->setTitle($query);                                                                                      
        return 'NoResults';
      }
    }
    else
    {
      // on direct visit
      $this->redirect($this->getRequest()->getReferer());
    }
  }
 
  public function executeAttiSearch()
  {
    // determine if the user pressed the "Advanced"  button
    if ($this->getRequestParameter('commit') == $this->translate('Advanced'))
    {
      // user did, so redirect to advanced search
      $this->redirect($this->getModuleName() . '/advancedSearch');
    }

    $this->advanced_enabled = sfConfig::get('sf_solr_interface_advanced', true);

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

    $page = (int) $this->getRequestParameter('page', 1);
    
    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));
	  
                                                                                     
    // did user enter a query?                                                       
    if ($query)                                                                      
    {                                                                                
      // query is passed back to the view, to fill the input field                   
      $this->query = $query;                                                         
                                                                                     
      // constraints on the query are built from the type                            
      $fields_constraints = array('sfl_model' => 'OppAtto', 'tipo_atto_s' => $this->type); 

      $pager = new sfSolrPager();
      $pager->setMaxPerPage($itemsperpage);

      $offset = ($page - 1) * $pager->getMaxPerPage();
      
      $pager->setSearch($this->getSolrInstance());

      try {
        $pager->setResults($this->getResults($query, $offset, $pager->getMaxPerPage(), $fields_constraints));
      } catch (sfSolrException $e) {
       $this->setTitle($query);
       $this->query = $query;
       return 'NoResults';
      }

      
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
      // on direct visits, redirect to atti lists                                    
      $this->redirect($this->pages_routes[$this->type]);                             
    }                                                                                
  }

  public function executeVotazioniSearch()                                                                  
  {
    // determine if the user pressed the "Advanced"  button                                                 
    if ($this->getRequestParameter('commit') == $this->translate('Advanced'))                               
    {                                                                                                       
      // user did, so redirect to advanced search                                                           
      $this->redirect($this->getModuleName() . '/advancedSearch');                                          
    }                                                                                                       
                                                                                                            
    $this->advanced_enabled = sfConfig::get('sf_solr_interface_advanced', true);                            
                                                                                                            
    $query = $this->getRequestParameter('query');                                                           
    $this->title = 'nelle votazioni';                                                                       

    $page = (int) $this->getRequestParameter('page', 1);

    if ($this->hasRequestParameter('itemsperpage'))
      $this->getUser()->setAttribute('itemsperpage', $this->getRequestParameter('itemsperpage'));
    $itemsperpage = $this->getUser()->getAttribute('itemsperpage', sfConfig::get('app_pagination_limit'));
                                                                                                            
    // did user enter a query?                                                                              
    if ($query)                                                                                             
    {                                                                                                       
      // query is passed back to the view, to fill the input field                                          
      $this->query = $query;                                                                                
                                                                                                            
      // constraints on the query are built from the type                                                   
      $fields_constraints = array('sfl_model' => 'OppVotazione');

      // build pager and get fields constraints
      $pager = new sfSolrPager();
      $pager->setMaxPerPage($itemsperpage);
      
      $offset = ($page - 1) * $pager->getMaxPerPage();
      $pager->setSearch($this->getSolrInstance());

      try {
        $results = $this->getResults($query, $offset, $pager->getMaxPerPage(), $fields_constraints);
        $pager->setResults($results);
      } catch (sfSolrException $e) {
       $this->setTitle($query);
       $this->query = $query;
       $this->error = $e->getMessage();
       return 'NoResults';
      }
      $num = $pager->getNbResults();                                                                        
                                                                                                            
      // were any results returned?                                                                         
      if ($num > 0)                                                                                         
      {                                                                                                     
        $this->safelySetPagerPage($pager, $page);

        $this->num = $num;
        
        $this->qTime = $results->getQTime();
        $this->start = $results->getStart();
        $this->rows = min($results->getRows(), $num);
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
      // on direct visits, redirect to votazioni lists                                                      
      $this->redirect('@votazioni');                                                                        
    }                                                                                                       
  }                                                                                                         
                                                                                                            
                                                                                                            
  /**                                                                                                       
   * a modified override for the getResults method, that accept an array of fields constraints              
   *                                                                                                        
   * @param string $querystring     
   * @param int    $offset
   * @param int    $limit                                                                        
   * @param string $fields_constraints  a hash of the form $field => $constraint - ('model' => 'OppAtto') 
   * @return sfSolrPager                                                                                           
   * @author Guglielmo Celata                                                                               
   */                                                                                                       
  protected function getResults($querystring, $offset = 0, $limit = 10, $fields_constraints = array())
  {
    try {
      $results = deppOppSolr::getSfResults($querystring, $offset, $limit, $fields_constraints);
      return $results;
    } catch (sfSolrException $e) {
      throw new sfSolrException($e->getMessage());
    }
  }   
  
  
  /**
  * Wrapper function for setting the title.  Overload to append or prepend
  * something to the title specific to your application.
  */
  protected function setTitle($title)
  {
    $this->getResponse()->setTitle(sprintf("Ricerca per %s - %s", $title, sfConfig::get('app_main_title')));
  }
                                                                                                        
  /**
   * Returns an instance of sfSolr configured for this environment.
   */
  protected function getSolrInstance()
  {
    return deppOppSolr::getInstance();
  }
   
   

  
}
