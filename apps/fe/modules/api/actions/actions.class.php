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
   *          <presenze>
   *            <numero>3898</numero>
   *            <percentuale>84,59</percentuale>
   *            <totale>
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
   *          <circoscrizione>Lombardia 1</circoscrizione>
   *        </parlamentare>
   *        ...
   *      </camera>
   *      <senato>
   *        <parlamentare> ... </parlamentare>
   *      </camera>
   *    </op:content>
   *  </opkw>
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
    $limit = $this->getRequestParameter('limit');

    // to do: add api keys management
    $is_valid_key = true;
    // $is_valid_key = OpApiKeysPeer::isValidKey($key);

    $resp_node = new SimpleXMLElement(
      '<opkw xmlns="'.$this->opkw_ns.'" '.
            ' xmlns:op="'.$this->op_ns.'" '.
            ' xmlns:xlink="'.$this->xlink_ns.'" >'.
      '</opkw>');
      
    $this->addProcessingInstruction($resp_node, 'xml-stylesheet', 'type="text/xsl" href="parlamentari.xslt"');
    

    if ($is_valid_key)
    {
  		// start producing xml
      $content_node = $resp_node->addChild('op:content', null, $this->op_ns);         

      $camera_node = $content_node->addChild('camera', null, $this->opkw_ns);
      $camera_node->addAttribute('n_rappresentanti', 
                                 $limit < OppCaricaPeer::getNParlamentari('C')? $limit : OppCaricaPeer::getNParlamentari('C'));
      $deputati = OppCaricaPeer::getActiveMps('C', $limit);
      foreach ($deputati as $parlamentare) {
        $this->addParlamentareNode($camera_node, $parlamentare);
      }

      $senato_node = $content_node->addChild('senato', null, $this->opkw_ns);
      $senato_node->addAttribute('n_rappresentanti', 
                                 $limit < OppCaricaPeer::getNParlamentari('S')?$limit : OppCaricaPeer::getNParlamentari('S'));
      $senatori = OppCaricaPeer::getActiveMps('S', $limit);
      foreach ($senatori as $parlamentare) {
        $this->addParlamentareNode($senato_node, $parlamentare);
      }

    } 
    else 
    {
      $resp_node->addChild('op:error', 'Chiave di accesso non valida', $this->op_ns);
    }

    $xmlContent = $resp_node->asXML();
    $this->_send_output($xmlContent);
    return sfView::NONE;
  }


  protected function addParlamentareNode($node, $parlamentare)
  {
    $parlamentare_node = $node->addChild('parlamentare');

    $width = 40; $height = 53;

    $image_node = $parlamentare_node->addChild('thumbnail');
    $image_node->addAttribute('xlink:href', 
                              OppPoliticoPeer::getThumbUrl($parlamentare->getOppPolitico()->getId()), $this->xlink_ns);
    $image_node->addAttribute('width', $width);
    $image_node->addAttribute('height', $height);

    $parlamentare_node->addChild('nome', $parlamentare->getOppPolitico()->getNome());
    $parlamentare_node->addChild('cognome', $parlamentare->getOppPolitico()->getCognome());
    $parlamentare_node->addChild('circoscrizione', $parlamentare->getCircoscrizione());

    $gruppo_node = $parlamentare_node->addChild('gruppo');
    $gruppo_node->addChild('nome', $parlamentare->getGruppo()->getNome());        
    $gruppo_node->addChild('acronimo', $parlamentare->getGruppo()->getAcronimo());    
    
    if ($data_inizio = $parlamentare->getDataInizio('Y-m-d') > '2008-04-29')
      $parlamentare_node->addChild('data_inizio', $parlamentare->getDataInizio('d/m/Y'));    
      
    $presenze = $parlamentare->getPresenze();
    $assenze = $parlamentare->getAssenze();
    $missioni = $parlamentare->getMissioni();
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
    
    $presenze_node = $parlamentare_node->addChild('presenze');
    $presenze_node->addChild('numero', $presenze);
    $presenze_node->addChild('percentuale', $presenze_perc);
    $presenze_node->addChild('totale', $n_votazioni);

    $assenze_node = $parlamentare_node->addChild('assenze');
    $assenze_node->addChild('numero', $assenze);
    $assenze_node->addChild('percentuale', $assenze_perc);
    $assenze_node->addChild('totale', $n_votazioni);

    $missioni_node = $parlamentare_node->addChild('missioni');
    $missioni_node->addChild('numero', $missioni);
    $missioni_node->addChild('percentuale', $missioni_perc);
    $missioni_node->addChild('totale', $n_votazioni);
    
    // TODO: aggiungere mese precedente
    $parlamentare_node->addChild('mese_precedente', 0);
    
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
