<?php
/*
 * This file is part of the sfSolrPlugin package
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
* This class extends the basic sfSolr class, wuth specific Opp instructions.
*
* @author     Guglielmo Celata <g.celata@depp.it>
* @package    sfSolrPlugin
*/
class deppOppSolr extends sfSolr
{
  
  /**                                                                                                       
   * get results as sfSolrPager (friendlySearch) and accepts fields_constraints as a parameter
   *                                                                                                        
   * @param string $querystring     
   * @param int    $offset
   * @param int    $limit                                                                        
   * @param array $fields_constraints  a hash of the form $field => $constraint - (ex: 'model' => 'OppAtto') 
   * @param boolean $quotes_mode  specifies wether terms should be only searched as quoted text (for Alerts)
   * @return sfSolrPager                                                                                      
   * @throws sfSolrException     
   * @author Guglielmo Celata                                                                               
   */                                                                                                       
  public static function getSfResults($querystring, $offset = 0, $limit = 10, $fields_constraints = array(), $quotes_mode = false)
  {
    $query = strip_tags(trim($querystring));   
    
    // opzioni aggiuntive per la ricerca
    $query_options = array('fl' => '*,score');
    
    $q_first = ""; $quoted = false;
   	if (strpos($query, '"') === false)                                                                
   	{                                                                                                       
      // se utente non ha inserito esplicitamente le virgolette
      // crea stringhe quoted e q_first 
   	  $words = split(" ", $query);                                                                    
   		$q_first = $words[0];		                                                                              
   	  $quoted = '"' . $query . '"';                                                                   
   	} else {
   	  // se utente ha inserito virgolette, entra in quotes_mode
   	  // con la stringa quoted uguale alla query
   	  $quotes_mode = true;
   	  $quoted = $query;
   	}                                                                                                     

   	// definizione dei boost (spostare in config??)                                                         
   	$nominativo_boost = 10.0;                                                                                  
   	$triple_value_boost = 6.0;                                                                                       
   	$titolo_boost = 6.0;                                                                                       
   	$testo_boost = 1.5;                                                                                
   	$descrizioneWiki_boost = 1.0;

   	$quoted_boost = 5.0;
   	$qfirst_boost = 2.0;


   	// compone la query ponderata                                                                           
    $composed_query  = "+(";                                                                                
    if ($quoted)                                                                                            
    {                                                                                                       
      $composed_query .= " nominativo: ($quoted)^" . $nominativo_boost * $quoted_boost . " ";                       
      $composed_query .= " triple_value: ($quoted)^" . $triple_value_boost  * $quoted_boost . " ";                                   
      $composed_query .= " titolo: ($quoted)^" . $titolo_boost * $quoted_boost  . " ";                                             
      $composed_query .= " testo: ($quoted)^" . $testo_boost * $quoted_boost . " ";                        
      $composed_query .= " descrizioneWiki: ($quoted)^" . $descrizioneWiki_boost * $quoted_boost . " ";                          
    }  
    
    // aggiunge ricerca per termini che iniziano come il primo termine e in OR su tutti i termini
    if ($quotes_mode == false)
    {
      if ($q_first)                                                                                           
      {                                                                                                       
        $composed_query .= " nominativo: ($q_first*)^" . $nominativo_boost * $qfirst_boost . " ";                     
        $composed_query .= " triple_value: ($q_first*)^" . $triple_value_boost * $qfirst_boost . " ";                                 
        $composed_query .= " titolo: ($q_first*)^" . $titolo_boost * $qfirst_boost . " ";                                           
        $composed_query .= " testo: ($q_first*)^" . $testo_boost * $qfirst_boost . " ";                      
        $composed_query .= " descrizioneWiki: ($q_first*)^" . $descrizioneWiki_boost * $qfirst_boost . " ";
      }                                                                                                       

      $composed_query .= " nominativo:(" . $query . ")^" . $nominativo_boost;                   
      $composed_query .= " triple_value:(" . $query . ")^" . $triple_value_boost;                               
      $composed_query .= " titolo:(" . $query . ")^" . $titolo_boost;                                         
      $composed_query .= " testo:(" . $query . ")^" . $testo_boost;                    
      $composed_query .= " descrizioneWiki:(" . $query . ")^" . $descrizioneWiki_boost;                            
    }                                                                                                     

    $composed_query .= ") ";                                                                                

    // aggiunge i constraints (+ obbligatori)
    if ($fields_constraints == '') $fields_constraints = array();                                           
    foreach ($fields_constraints as $field => $constraint)                                                  
    {
      $composed_query .= " +$field:$constraint ";
    }                                                                                                       

    # query debug        
    if (sfConfig::get('solr_query_debug', 1))
    {
      sfLogger::getInstance()->info('{sfSolrActions::getResults::query} ' . $query);                                                  
      sfLogger::getInstance()->info('{sfSolrActions::getResults::composed_query} ' . $composed_query);    
      sfLogger::getInstance()->info('{sfSolrActions::getResults::offset} ' . $offset);                                                  
      sfLogger::getInstance()->info('{sfSolrActions::getResults::limit} ' . $limit);                                                                                                      
    }                                                                                   

    // returns the pager or trap the exception
    try {                                                                                                                                                                       
      $results = deppOppSolr::getInstance()->friendlySearch($composed_query, $offset, $limit, $query_options);
      return $results;

    } catch (Exception $e) {                                                                                
      sfLogger::getInstance()->err('{sfSolrActions::getResults} ' . $e->getMessage());
      throw new sfSolrException($e->getMessage());
    }                                                                                                       

  }  
 
  /**
  * Singleton.  Gets the instance
  */
  static public function getInstance()
  {
    static $instance;

    if (!isset($instance))
    {
      $instance = new self;
    }

    
    
    return $instance;
  }

  
  
  /**
  * Searches the index for the query and returns them with a symfony friendly interface.
  * @param mixed $query The query
  * @return sfSolrResults The symfony friendly results.
  */
  public function friendlySearch($query, $offset=0, $limit=10, $options = array())
  {
    sfLogger::getInstance()->info('{deppOppSolr::friendlySearch::query} ' . $query);    
    sfLogger::getInstance()->info('{deppOppSolr::friendlySearch::offset} ' . $offset);                                                  
    sfLogger::getInstance()->info('{deppOppSolr::friendlySearch::limit} ' . $limit);                                                                                                      
    
    $response = $this->search($query, $offset, $limit, $options);
    
    return new deppOppSolrResults($response, $this);
  }
   
}
?>