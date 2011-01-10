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
    
    $date_filter = $this->getRequestParameter('date_filter', '');
    
    $type_filters_s = $this->getRequestParameter('type_filters', '');    
    if ($type_filters_s != '') {
      $type_filters = explode("|", $type_filters_s);
    } else {
      $type_filters = array();
    }
    
    // if a switch_filter param was passed, then the filter is switched
    // and the filters string re-generated
    if ($this->hasRequestParameter('switch_filter')) {
      $switch_filter = $this->getRequestParameter('switch_filter', '');
      if ($idx = array_search($switch_filter, $type_filters)) {
        array_splice($type_filters, $idx, 1);
      } else {
        array_push($type_filters, $switch_filter);
      }
      $type_filters_s = implode("|", $type_filters);
    }
    
    $sort = $this->getRequestParameter('sort', '');
    
    // did user enter a query?
    if ($query)
    {
      sfContext::getInstance()->getLogger()->info('{sfSolr} query: ' . $query);

      $fields_constraints = '';
      
      if ($date_filter != '') {
        switch ($date_filter) {
          case 'today':
            $fields_constraints .= "data_pres_dt:[NOW-1DAYS/SECOND TO NOW]";
            break;
          
          case 'week':
            $fields_constraints .= "data_pres_dt:[NOW-7DAYS/SECOND TO NOW]";
            break;

          case 'month':
            $fields_constraints .= "data_pres_dt:[NOW-1MONTH/SECOND TO NOW]";
            break;

          case 'semester':
            $fields_constraints .= "data_pres_dt:[NOW-6MONTHS/SECOND TO NOW]";
            break;
          
          case 'year':
            $fields_constraints .= "data_pres_dt:[NOW-1YEAR/SECOND TO NOW]";
            break;
        }
        
      }
      
      
      if (count($type_filters)) {
        $type_constraints = "";
        foreach ($type_filters as $cnt => $type_filter) {
          $type_constraint = "";
          switch ($type_filter) {
            case 'politici':
              $type_constraint ="(+sfl_model:OppPolitico)";
              break;
            case 'argomenti':
              $type_constraint = "(+sfl_model:Tag)";
              break;
            case 'emendamenti':
              $type_constraint = "(+sfl_model:OppEmendamento)";
              break;
            case 'votazioni':
              $type_constraint = "(+sfl_model:OppVotazione)";
              break;
            case 'resoconti':
              $type_constraint = "(+sfl_model:OppResoconto)";
              break;
            case 'disegni':
            case 'decreti':
            case 'decrleg':
            case 'mozioni':
            case 'interpellanze':
            case 'interrogazioni':
            case 'risoluzioni':
            case 'odg':
            case 'comunicazionigoverno':
            case 'audizioni':
              $type_constraint = "(+sfl_model:(OppAtto OppDocumento) +tipo_atto_s:$type_filter)";
              break;          
          }
          $type_constraints .= ($cnt > 0?' OR ':'') . $type_constraint;
        }
        if ($type_constraints != "") {
          $fields_constraints .= ($fields_constraints != ''?" AND ($type_constraints)":$type_constraints);
        }
      }

      switch ($sort) {
        case 'date':
          $sort_specification = 'data_pres_dt desc';
          break;
        
        default:
          $sort_specification = '';
          break;
      }
      
 
      $pager = new sfSolrPager();
      $pager->setMaxPerPage($itemsperpage);

      $offset = ($page - 1) * $pager->getMaxPerPage();
 
      $pager->setSearch($this->getSolrInstance());
 
      try {
        $pager->setResults($this->getResults($query, $offset, $pager->getMaxPerPage(), $fields_constraints, $sort_specification));      
      } catch (sfSolrException $e) {
        $this->setTitle($query);
        $this->query = $query;
        return 'NoResults';
      }
 
      $num = $pager->getNbResults();

      $this->safelySetPagerPage($pager, $page);

      $this->num = $num;
      $pager_results = $pager->getResults();
 
      $this->qTime = $pager_results->getQTime();
      $this->start = $pager_results->getStart();
      $this->rows = min($pager_results->getRows(), $num);
      $this->pager = $pager;
      $this->query = $query;
      $this->date_filter = $date_filter;
      $this->type_filters = $type_filters_s;
      $this->sort = $sort;
      
      $search_route =  "@sf_solr_search_results?query=$query"; 
      if (strpos($search_route, '.')) {
        sfConfig::set('sf_no_script_name', 0);
      }
      $this->base_search_route = $search_route;
      
      if ($date_filter != '') $search_route .= "&date_filter=$date_filter";
      if ($type_filters_s != '') $search_route .= "&type_filters=$type_filters_s"; 
      $this->pager_search_route = $search_route;
      

      $this->setTitle($query);

      return 'Results';
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
   * @param mixed $fields_constraints  a string or a hash of the form $field => $constraint - ('model' => 'OppAtto') 
   * @param string $sort    
   * @return sfSolrPager                                                                                           
   * @author Guglielmo Celata                                                                               
   */                                                                                                       
  protected function getResults($querystring, $offset = 0, $limit = 10, $fields_constraints = array(), $sort = '')
  {
    try {
      $results = deppOppSolr::getSfResults($querystring, $offset, $limit, $fields_constraints, false, $sort);
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
