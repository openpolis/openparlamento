<?php

/**
 * api actions.
 *
 * @package    op_openparlamento
 * @subpackage api
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class apiActions extends sfActions
{

  var $opkw_ns = 'http://www.openpolis.it/2010/opkw';
  var $op_ns = 'http://www.openpolis.it/2010/op';
  var $xlink_ns = 'http://www.w3.org/1999/xlink';

  /**
   * API (protetta da una API key)
   * torna flusso xml di tutti i parlamentari (divisi per ramo)
   * per ciascun parlamentare, visualizza i dati anagrafici e di carica
   * nonché informazioni variabili, a seconda del parametro info_type
   *  - presenze: presenze, assenza, missione
   *  - attivita: indice di attività parlamentare (nuovo)
   *  - ribelli:  numero di voti ribelli
   * progetto op_kw
   *
   *  <opkw xmlns="http://www.openpolis.it/2010/opkw"
   *         xmlns:op="http://www.openpolis.it/2010/op"
   *         xmlns:op_location="http://www.openpolis.it/2010/op_location"
   *         xmlns:op_politician="http://www.openpolis.it/2010/op_politician"
   *         xmlns:xlink="http://www.w3.org/1999/xlink">
   *    <op:content> 
   *      <camera n_rappresentanti="600">
   *        <parlamentare xlink:href="parlamentari/12345.xml">
   *          <thumbnail xlink:href="parlamentari/thumb/332104.jpeg" width="40" height="53"/>
   *          <nome>NOME</nome>
   *          <cognome>COGNOME</cognome>
   *          <gruppo>
   *            <nome>NOME GRUPPO</nome>
   *            <acronimo>NOME GRUPPO</acronimo>
   *          </gruppo>
   *          <data_inizio_carica>2008-04-12</data_inizio_carica> ** solo se successiva a data inizio leg.
   *          <circoscrizione>Lombardia 1</circoscrizione>
   *
   *          ...* informazioni *...
   *
   *        </parlamentare>
   *        ...
   *      </camera>
   *      <senato>
   *        <parlamentare> ... </parlamentare>
   *      </camera>
   *    </op:content>
   *  </opkw>
   *
   * Informazioni possono essere:
   *          <presenze>
   *            <numero>3898</numero>
   *            <percentuale>84,59</percentuale>
   *          </presenze>
   *          <assenze>
   *            <numero>710</numero>
   *            <percentuale>15,41</percentuale>
   *          </assenze>
   *          <missioni>
   *            <numero>0</numero>
   *            <percentuale>0,00</percentuale>
   *          </missioni>
   *          <mese_precedente>+1</mese_precedente>
   *
   *          <indice>
   *            <numero>389,8</numero>
   *          </indice>
   *          <mese_precedente>+-1</mese_precedente>
   *
   *          <voti_ribelli>
   *            <numero>15</numero>
   *          </indice>
   *          <mese_precedente>-1</mese_precedente>
   *       
   * Return error in case something's wrong
   * <opkw xlmns="http://www.openpolis.it/2010/opkw"
   *       xmlns:op="http://www.openpolis.it/2010/op"
   *       xlmns:op_location="http://www.openpolis.it/2010/op_location"
   *       xmlns:op_politician="http://www.openpolis.it/2010/op_politician">
   *   <op:error>Messaggio di errore</op:error>
   * </opkw>
   * @return String
   * @author Guglielmo Celata
   **/
  public function executeElencoParlamentari()
  {
    $key = $this->getRequestParameter('key');
    $infotype = $this->getRequestParameter('infotype');
    $order_by = $this->getRequestParameter('orderby');
    $order_type = $this->getRequestParameter('ordertype');
    
		$con = Propel::getConnection('propel');

    $current_data = OppPoliticianHistoryCachePeer::fetchLastData($con);

    $is_valid_key = deppApiKeysPeer::isValidKey($key);

    $resp_node = new SimpleXMLElement(
      '<opkw xmlns="'.$this->opkw_ns.'" '.
            ' xmlns:op="'.$this->op_ns.'" '.
            ' xmlns:xlink="'.$this->xlink_ns.'" >'.
      '</opkw>');
      
    // $this->addProcessingInstruction($resp_node, 'xml-stylesheet', 'type="text/xsl" href="parlamentari.xslt"');
    

    if ($is_valid_key)
    {
  		// start producing xml
      $content_node = $resp_node->addChild('op:content', null, $this->op_ns);         


      // camera
      $camera_node = $content_node->addChild('camera', null, $this->opkw_ns);      

      // dato storico aggregato per tutto il ramo
      $c_ramo_node = $camera_node->addChild('ramo', null, $this->opkw_ns);
      $rs = OppPoliticianHistoryCachePeer::getKWRamoRS('C', $con);
      $cnt = 0;
      while ($rs->next()) {
        $cnt++;
        $r = $rs->getRow();
        $this->addRamoNode($c_ramo_node, $r, $infotype);
      }

      // gruppi
      $c_gruppi_node = $camera_node->addChild('gruppi', null, $this->opkw_ns);
      $n_gruppi = OppPoliticianHistoryCachePeer::countByDataRamoChiTipo($current_data, 'C', 'G', $con);
      $rs = OppPoliticianHistoryCachePeer::getKWGruppoRSByDataRamo($current_data, 'C', null, null, $con);
      $cnt = 0;
      while ($rs->next()) {
        $cnt++;
        $g = $rs->getRow();
        $this->addGruppoNode($c_gruppi_node, $g, $infotype, $cnt);
      }
      $c_gruppi_node->addAttribute('n_gruppi', $n_gruppi);
      
      // parlamentari
      $deputati_node = $camera_node->addChild('parlamentari', null, $this->opkw_ns);
      $n_deputati = OppPoliticianHistoryCachePeer::countByDataRamoChiTipo($current_data, 'C', 'P', $con);
      $rs = OppPoliticianHistoryCachePeer::getKWPoliticoRSByDataRamo($current_data, 'C', $order_by, $order_type, $con);
      $cnt = 0;
      while ($rs->next()) {
        $cnt++;
        $p = $rs->getRow();
        $this->addParlamentareNode($deputati_node, $p, $infotype, $cnt);
      }
      $deputati_node->addAttribute('n_rappresentanti', $n_deputati);


      // senato
      $senato_node = $content_node->addChild('senato', null, $this->opkw_ns);
      
      // ramo (storico)
      $s_ramo_node = $senato_node->addChild('ramo', null, $this->opkw_ns);
      $rs = OppPoliticianHistoryCachePeer::getKWRamoRS('S', $con);
      $cnt = 0;
      while ($rs->next()) {
        $cnt++;
        $r = $rs->getRow();
        $this->addRamoNode($s_ramo_node, $r, $infotype);
      }
      
      // gruppi
      $s_gruppi_node = $senato_node->addChild('gruppi', null, $this->opkw_ns);
      $n_gruppi = OppPoliticianHistoryCachePeer::countByDataRamoChiTipo($current_data, 'S', 'G', $con);
      $rs = OppPoliticianHistoryCachePeer::getKWGruppoRSByDataRamo($current_data, 'S', null, null, $con);
      $cnt = 0;
      while ($rs->next()) {
        $cnt++;
        $g = $rs->getRow();
        $this->addGruppoNode($s_gruppi_node, $g, $infotype);
      }
      $s_gruppi_node->addAttribute('n_gruppi', $n_gruppi);
      
      // parlamentari
      $senatori_node = $senato_node->addChild('parlamentari', null, $this->opkw_ns);
      $n_senatori = OppPoliticianHistoryCachePeer::countByDataRamoChiTipo($current_data, 'S', 'P', $con);
      $rs = OppPoliticianHistoryCachePeer::getKWPoliticoRSByDataRamo($current_data, 'S', $order_by, $order_type, $con);
      $cnt = 0;
      while ($rs->next()) {
        $cnt++;
        $p = $rs->getRow();
        $this->addParlamentareNode($senatori_node, $p, $infotype, $cnt);
      }
      $senatori_node->addAttribute('n_rappresentanti', $n_senatori);

    } 
    else 
    {
      $resp_node->addChild('op:error', 'Chiave di accesso non valida', $this->op_ns);
    }

    $xmlContent = $resp_node->asXML();
    $this->_send_output($xmlContent);
    return sfView::NONE;
  }


  protected function addParlamentareNode($node, $p, $infotype, $n)
  {
    $parlamentare_node = $node->addChild('parlamentare');
    $parlamentare_node->addAttribute('n_prog', $n);

    $width = 40; $height = 53;

    $image_node = $parlamentare_node->addChild('thumbnail');
    $image_node->addAttribute('xlink:href', 
                              OppPoliticoPeer::getThumbUrl($p['politico_id']), $this->xlink_ns);
    $image_node->addAttribute('width', $width);
    $image_node->addAttribute('height', $height);

    $parlamentare_node->addChild('nome', $p['nome']);
    $parlamentare_node->addChild('cognome', $p['cognome']);
    $parlamentare_node->addChild('circoscrizione', $p['circoscrizione']);

    $gruppo_node = $parlamentare_node->addChild('gruppo');
    $gruppo_node->addChild('nome', $p['gruppo_nome']);        
    $gruppo_node->addChild('acronimo', $p['gruppo_acronimo']);    
    
    if ($data_inizio = $p['data_inizio'] > '2008-04-29')
      $parlamentare_node->addChild('data_inizio', $p['data_inizio']);    

    call_user_func_array(array($this, 'addInfo'.ucfirst($infotype)), array($parlamentare_node, $p));
    
  }
  

  protected function addGruppoNode($node, $g, $infotype)
  {
    $gruppo_node = $node->addChild('gruppo');
    $gruppo_node->addAttribute('id', $g['gruppo_id']);

    $gruppo_node->addChild('nome', $g['nome']);
    $gruppo_node->addChild('acronimo', $g['acronimo']);

    call_user_func_array(array($this, 'addInfo'.ucfirst($infotype)), array($gruppo_node, $g));
    
  }
  
  
  protected function addRamoNode($node, $r, $infotype)
  {
    $dato_node = $node->addChild('dato_storico');
    $dato_node->addAttribute('data', $r['data']);

    call_user_func_array(array($this, 'addInfo'.ucfirst($infotype)), array($dato_node, $r, false));
    
  }
  
  public function addInfoPresenze($node, $item, $prec = true)
  {
    $presenze = $item['presenze'];
    $assenze = $item['assenze'];
    $missioni = $item['missioni'];
    $n_votazioni = $presenze + $assenze + $missioni;
    
    if ($n_votazioni == 0)
    {
      $presenze_perc = 0;
      $assenze_perc = 0;
      $missioni_perc = 0;
    } else {
      $presenze_perc = number_format($presenze*100/$n_votazioni,2);
      $assenze_perc = number_format($assenze*100/$n_votazioni,2);
      $missioni_perc = number_format($missioni*100/$n_votazioni,2);          
    }
    
    $presenze_node = $node->addChild('presenze');
    $presenze_node->addChild('numero', $presenze);
    $presenze_node->addChild('percentuale', $presenze_perc);
    $presenze_node->addChild('totale', $n_votazioni);
    
    if ($prec) {
      $delta = $item['presenze_delta'];
      $presenze_node->addChild('mese_precedente', $delta>0?1:($delta==0?0:-1));
    }

    $assenze_node = $node->addChild('assenze');
    $assenze_node->addChild('numero', $assenze);
    $assenze_node->addChild('percentuale', $assenze_perc);
    $assenze_node->addChild('totale', $n_votazioni);
    if ($prec) {
      $delta = $item['assenze_delta'];
      $assenze_node->addChild('mese_precedente', $delta>0?1:($delta==0?0:-1));
    }

    $missioni_node = $node->addChild('missioni');
    $missioni_node->addChild('numero', $missioni);
    $missioni_node->addChild('percentuale', $missioni_perc);
    $missioni_node->addChild('totale', $n_votazioni);
    if ($prec) {
      $delta = $item['missioni_delta'];
      $missioni_node->addChild('mese_precedente', $delta>0?1:($delta==0?0:-1));
    }
  }
  
  public function addInfoAttivita($node, $item, $prec = true)
  {
    $indice = $item['indice'];
    $indice_node = $node->addChild('indice');
    if (!is_null($indice))
    {
      $indice_node->addChild('numero', $indice);      
    }
    
    if ($prec) {
      $delta = $item['indice_delta'];
      $indice_node->addChild('mese_precedente', $delta>0?1:($delta==0?0:-1));
    }
  }
  
  public function addInfoRibelli($node, $item, $prec = true)
  {
    $voti_ribelli = $item['ribellioni'];
    $voti_ribelli_node = $node->addChild('voti_ribelli');
    $voti_ribelli_node->addChild('numero', $voti_ribelli);

    if ($prec) {
      $delta = $item['ribellioni_delta'];
      $voti_ribelli_node->addChild('mese_precedente', $delta>0?1:($delta==0?0:-1));
    }
  }
  

  public function executeGetClassifiche()
  {
    $c = new Criteria();
    $c->clearSelectColumns();
    $c->addSelectColumn(OppCaricaPeer::ID);             // 1
    $c->addSelectColumn(OppPoliticoPeer::ID);           // 2
    $c->addSelectColumn(OppPoliticoPeer::COGNOME);      // 3
    $c->addSelectColumn(OppPoliticoPeer::NOME);         // 4
    $c->addSelectColumn(OppCaricaPeer::CIRCOSCRIZIONE); // 5
    $c->addSelectColumn(OppCaricaPeer::PRESENZE);       // 6
    $c->addSelectColumn(OppCaricaPeer::ASSENZE);        // 7
    $c->addSelectColumn(OppCaricaPeer::MISSIONI);       // 8
    $c->addSelectColumn(OppCaricaPeer::INDICE);         // 9
    $c->addSelectColumn(OppCaricaPeer::POSIZIONE);      // 10
    $c->addSelectColumn(OppCaricaPeer::MEDIA);          // 11
    $c->addSelectColumn(OppCaricaPeer::RIBELLE);        // 12
    $c->addSelectColumn(OppPoliticoPeer::N_MONITORING_USERS); // 13
    $c->addJoin(OppCaricaPeer::POLITICO_ID, OppPoliticoPeer::ID, Criteria::INNER_JOIN);
    $c->add(OppCaricaPeer::DATA_FINE,NULL,Criteria::ISNULL);

    $deputati = array(); $senatori = array();
    $deputati['presenti'] = $this->_get_most_something($c, 1, OppCaricaPeer::PRESENZE);
    $senatori['presenti'] = $this->_get_most_something($c, 4, OppCaricaPeer::PRESENZE);
    $deputati['assenti'] = $this->_get_most_something($c, 1, OppCaricaPeer::ASSENZE);
    $senatori['assenti'] = $this->_get_most_something($c, 4, OppCaricaPeer::ASSENZE);
    $deputati['attivi'] = $this->_get_most_something($c, 1, OppCaricaPeer::INDICE);
    $senatori['attivi'] = $this->_get_most_something($c, 4, OppCaricaPeer::INDICE);
    $deputati['monitorati'] = $this->_get_most_something($c, 1, OppPoliticoPeer::N_MONITORING_USERS);
    $senatori['monitorati'] = $this->_get_most_something($c, 4, OppPoliticoPeer::N_MONITORING_USERS);
    $deputati['ribelli'] = $this->_get_most_something($c, 1, OppCaricaPeer::RIBELLE);
    $senatori['ribelli'] = $this->_get_most_something($c, 4, OppCaricaPeer::RIBELLE);
    
    $this->dep = $deputati; $this->sen = $senatori;
    sfConfig::set('sf_web_debug', false);
    $this->getResponse()->setContentType('text');
  }

  public function _get_most_something($crit, $tipo_carica, $field, $limit = null)
  {
    sfLoader::loadHelpers(array('Url', 'Tag'));
    
    // if limit was not passed, then get it from config file
    if (is_null($limit)) 
      $limit = sfConfig::get('app_api_classifiche_limit', 5);

    $c = clone $crit;
    $c->add(OppCaricaPeer::TIPO_CARICA_ID, $tipo_carica);
    $c->addDescendingOrderByColumn($field);
    $c->setLimit($limit); 
    $rs = OppCaricaPeer::doSelectRS($c);
    $results = array();
    while ($rs->next())
    {
      $record = array();
      $record['img_src'] = OppPoliticoPeer::getThumbUrl($rs->getInt(2));
      $record['nome'] = $rs->getString(3).' '.$rs->getString(4);
      $record['nome_link'] = url_for('@parlamentare?id='.$rs->getInt(2));
      
      $record['gruppi'] = '';
      $gruppi = OppCaricaHasGruppoPeer::doSelectGruppiPerCarica($rs->getInt(1));
      foreach($gruppi as $nome => $gruppo)
        if(!$gruppo['data_fine']) 
          $record['gruppi'] = " ($nome)";

      switch ($field)
      {
        case OppCaricaPeer::PRESENZE:
          $num_votazioni = $rs->getInt(6) + $rs->getInt(7) + $rs->getInt(8);
          $record['descr'] = "%s% - %d su %d";
          $record['values'] = array(number_format($rs->getInt(6)*100/$num_votazioni,2), $rs->getInt(6), $num_votazioni);
          break;
        case OppCaricaPeer::ASSENZE:
          $num_votazioni = $rs->getInt(6) + $rs->getInt(7) + $rs->getInt(8);
          $record['descr'] = "%s% - %d su %d";
          $record['values'] = array(number_format($rs->getInt(7)*100/$num_votazioni,2), $rs->getInt(7), $num_votazioni);
          break;
        case OppCaricaPeer::INDICE:
          $record['descr'] = "indice di attivit&agrave;: %5.2f";
          $record['values'] = array($rs->getFloat(9)); 
          break;
        case OppPoliticoPeer::N_MONITORING_USERS:
          $record['descr'] = "&egrave; monitorato da %d utenti";
          $record['values'] = array($rs->getInt(13));
          break;
        case OppCaricaPeer::RIBELLE:
          $record['descr'] = "voti diversi dal suo gruppo: %d su %d";
          $record['values'] = array($rs->getInt(12), $rs->getInt(6));
          break;
      }

      $results []= $record;
    }
    
    return $results;
  }


  protected function addProcessingInstruction( $xml_node, $name, $value )
  {
      // Create a DomElement from this simpleXML object
      $dom_sxe = dom_import_simplexml($xml_node);
     
      // Create a handle to the owner doc of this xml
      $dom_parent = $dom_sxe->ownerDocument;
     
      // Find the topmost element of the domDocument
      $xpath = new DOMXPath($dom_parent);
      $first_element = $xpath->evaluate('/*[1]')->item(0);
     
      // Add the processing instruction before the topmost element           
      $pi = $dom_parent->createProcessingInstruction($name, $value);
      $dom_parent->insertBefore($pi, $first_element);
  }


  /**
   * send xml output to http response
   *
   * @param string $content 
   * @return void
   * @author Guglielmo Celata
   */
  protected function _send_output($content)
  {
    $this->setLayout(false);    
    $this->response->setContentType('text/xml');
    $this->response->setContent($content);
  }

}
