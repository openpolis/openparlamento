<?php

/**
 * json actions.
 *
 * @package    op_openparlamento
 * @subpackage json
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class jsonActions extends sfActions
{

  public function executeGetLastDateForPoliticianHistoryCache($value='')
  {
    $last_date = OppPoliticianHistoryCachePeer::fetchLastData();
    $this->_send_json_output(json_encode(array('last_date' => $last_date)));    
    return sfView::NONE;
  }
  
  public function executeGetIndexChartsPoliticians()
  {
    return $this->getIndexChartsItems('getIndexChartsPoliticians');
  }

  public function executeGetIndexChartsRegions()
  {
    return $this->getIndexChartsItems('getIndexChartsRegions');
  }  

  public function executeGetIndexChartsGroups()
  {
    return $this->getIndexChartsItems('getIndexChartsGroups');
  }  

  public function executeGetIndexChartsSex()
  {
    return $this->getIndexChartsItems('getIndexChartsSex');
  }  

  protected function getIndexChartsItems($method)
  {
    # check query string parameters and validate against SQL injection
    $this->forward404Unless($this->hasRequestParameter('ramo'));
    $ramo = $this->getRequestParameter('ramo', '');
    $this->forward404Unless(in_array($ramo, array('C', 'S')));

    $this->forward404Unless($this->hasRequestParameter('data'));
    $data = $this->getRequestParameter('data', '');
    $this->forward404Unless(strtotime($data));    

    $items = call_user_func_array('OppPoliticianHistoryCachePeer::'.$method, array($ramo, $data));
    $this->_send_json_output(json_encode($items));    
    return sfView::NONE;
  }

  public function executeGetIndexChartsPoliticiansInConstituency()
  {
    $regioni = array(
      "piemonte",
      "valle-d-aosta",
      "lombardia",
      "trentino-alto-adige",
      "veneto",
      "friuli-venezia-giulia",
      "liguria",
      "emilia-romagna",
      "toscana",
      "umbria",
      "marche",
      "lazio",
      "abruzzo",
      "molise",
      "campania",
      "puglia",
      "basilicata",
      "calabria",
      "sicilia",
      "sardegna"
    );
    
    # check query string parameters and validate to avoid SQL injection
    $this->forward404Unless($this->hasRequestParameter('ramo'));
    $ramo = $this->getRequestParameter('ramo', '');
    $this->forward404Unless(in_array($ramo, array('C', 'S')));

    $this->forward404Unless($this->hasRequestParameter('data'));
    $data = $this->getRequestParameter('data', '');
    $this->forward404Unless(strtotime($data));

    $this->forward404Unless($this->hasRequestParameter('circoscrizione'));
    $circoscrizione = $this->getRequestParameter('circoscrizione', '');
    $circoscrizione_is_valid = false;
    foreach ($regioni as $regione) {
      if (strpos($circoscrizione, $regione) !== false) {
        $circoscrizione_is_valid = true; 
        break;
      }
    }
    $this->forward404Unless($circoscrizione_is_valid);

    $items = OppPoliticianHistoryCachePeer::getIndexChartsPoliticiansInConstituency($ramo, $data, $circoscrizione);
    $this->_send_json_output(json_encode($items));    
    return sfView::NONE;
  }
  
  public function executeGetIndexChartsTopPoliticians()
  {
    # check query string parameters and validate to avoid SQL injection
    $this->forward404Unless($this->hasRequestParameter('ramo'));
    $ramo = $this->getRequestParameter('ramo', '');
    $this->forward404Unless(in_array($ramo, array('C', 'S')));

    $this->forward404Unless($this->hasRequestParameter('data'));
    $data = $this->getRequestParameter('data', '');
    $this->forward404Unless(strtotime($data));
    
    $this->forward404Unless($this->hasRequestParameter('limit'));
    $limit = (int)$this->getRequestParameter('limit', '');
    $this->forward404Unless(is_integer($limit));

    $items = OppPoliticianHistoryCachePeer::getIndexChartsTopPoliticians($ramo, $data, $limit);
    $this->_send_json_output(json_encode($items));    
    return sfView::NONE;
  }
	

  /**
   * send json output to http response
   *
   * @param string $content 
   * @return void
   * @author Guglielmo Celata
   */
  protected function _send_json_output($content)
  {
    $this->setLayout(false);    
    $this->response->setContentType('application/json');
    $this->response->setContent($content);
  }
  
}
