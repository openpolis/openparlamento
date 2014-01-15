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

    var $regioni = array(
        "europa", "america meridionale", "america settentrionale e centrale",
        "asia-africa-oceania-antartide",
        "piemonte", "piemonte 1", "piemonte 2",
        "valle-d-aosta",
        "lombardia", "lombardia 1", "lombardia 2", "lombardia 3",
        "trentino-alto-adige",
        "veneto", "veneto 1", "veneto 2",
        "friuli-venezia-giulia",
        "liguria",
        "emilia-romagna",
        "toscana",
        "umbria",
        "marche",
        "lazio", "lazio 1", "lazio 2",
        "abruzzo",
        "molise",
        "campania", "campania 1", "campania 2",
        "puglia",
        "basilicata",
        "calabria",
        "sicilia",
        "sardegna"
    );

  public function executeGetLastDateForPoliticianHistoryCache($value='')
  {
    $last_date = OppPoliticianHistoryCachePeer::fetchLastData();
    $this->_send_json_output(json_encode(array('last_date' => $last_date)));    
    return sfView::NONE;
  }
  
  public function executeGetIndexChartsPoliticians()
  {
    $this->forward404Unless($this->hasRequestParameter('ramo'));
    $ramo = $this->getRequestParameter('ramo', '');
    $this->forward404Unless(in_array($ramo, array('C', 'S')));

    $this->forward404Unless($this->hasRequestParameter('data'));
    $data = $this->getRequestParameter('data', '');
    $this->forward404Unless(strtotime($data));    

    $items = call_user_func_array('OppPoliticianHistoryCachePeer::getIndexChartsPoliticians', array($ramo, $data));
    $items = $this->_add_data_inizio_incarico($items, $ramo, $data);
    $this->_send_json_output(json_encode($items));    
    return sfView::NONE;
    
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

  protected function getIndexChartsItems($method, $add_data_inizio_incarico = false)
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

    $politicians = OppPoliticianHistoryCachePeer::getIndexChartsPoliticiansInConstituency($ramo, $data, $circoscrizione);
    $items = $this->_add_data_inizio_incarico($politicians, $ramo, $data);
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

    $group_acr = $this->getRequestParameter('group', '');
    $group_id = null;
    if ($group_acr != '')
    {
        $c = new Criteria();
        $c->add(OppGruppoPeer::ACRONIMO, $group_acr);
        $group = OppGruppoPeer::doSelectOne($c);
        $this->forward404If(is_null($group));
        $group_id = $group->getId();
    }

    foreach ($this->regioni as $reg) {
        sfContext::getInstance()->getLogger()->info($reg);
    }

    $constituency = $this->getRequestParameter('circoscrizione', '');
    if ($constituency != '')
    {
      $constituency_is_valid = in_array(strtolower($constituency), $this->regioni);
      $this->forward404Unless($constituency_is_valid);
    }
    $items = OppPoliticianHistoryCachePeer::getIndexChartsTopPoliticians($ramo, $data, $limit, $group_id, $constituency);
    $this->_send_json_output(json_encode($items));
    return sfView::NONE;
  }

  public function _add_data_inizio_incarico($politicians, $ramo, $data)
  {
    $items = array();
    foreach ($politicians as $politician) {
      $politician_obj = OppPoliticoPeer::retrieveByPK($politician['politico_id']);
      $carica_corrente = $politician_obj->getCaricaDepSenCorrente();
      $data_inizio_incarico = $carica_corrente->getDataInizio();
      if ($data_inizio_incarico > sfConfig::get('app_legislatura_data_inizio', 2008))
        $politician['data_inizio_incarico'] = strftime('%d/%m/%Y', strtotime($data_inizio_incarico));
      array_push($items, $politician);
    }
    return $items;
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
