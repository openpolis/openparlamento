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
  var $opp_ns = 'http://www.openpolis.it/2010/opp';
  var $op_ns = 'http://www.openpolis.it/2010/op';
  var $xlink_ns = 'http://www.w3.org/1999/xlink';




  public function executeGetPolImage()
  {
    $key = $this->getRequestParameter('key');
    $id = $this->getRequestParameter('id');
    $is_valid_key = deppApiKeysPeer::isValidKey($key);

    $resp_node = new SimpleXMLElement(
      '<opkw xmlns="'.$this->opkw_ns.'" '.
            ' xmlns:op="'.$this->op_ns.'" '.
            ' xmlns:xlink="'.$this->xlink_ns.'" >'.
      '</opkw>');
      
    if ($is_valid_key)
    {
      $picture_url = OppPoliticoPeer::getPictureUrl($id);
      $thumb_url = OppPoliticoPeer::getThumbUrl($id);
      $content_node = $resp_node->addChild('op:content', null, $this->op_ns);         
      $picture_node = $content_node->addChild('picture', $picture_url, $this->opkw_ns);
      $thumb_node = $content_node->addChild('thumb', $thumb_url, $this->opkw_ns);
    } 
    else 
    {
      $resp_node->addChild('op:error', 'Chiave di accesso non valida', $this->op_ns);
    }

    $xmlContent = $resp_node->asXML();
    $this->_send_output($xmlContent);
    return sfView::NONE;
  }



  /**
   * API (protetta da una API key)
   * torna flusso xml con i dati di un singolo atto
   * progetto op_fb
   *
   * <opp xmlns="http://www.openpolis.it/2010/opp"
   *        xmlns:op="http://www.openpolis.it/2010/op"
   *        xmlns:xlink="http://www.w3.org/1999/xlink">
   *   <op:content> 
   *     <atto opp_id="38631">
   *       <legislatura>16</legislatura>
   *       <ramo>S</ramo>
   *       <numero>1611</numero>
   *       <titolo><![CDATA[
   *         [Ddl intercettazioni] Norme in materia di intercettazioni telefoniche, telematiche e ambientali. Modifica della disciplina in materia di astensione del giudice e degli atti di indagine. Integrazione della disciplina sulla responsabilità amministrativa delle persone giuridiche
   *         ]]>
   *       </titolo>
   *       <presentato_il>2009-06-11</presentato_il>
   *       <tipo_iniziativa>governo</tipo_iniziativa>
   *       <primi_firmatari>
   *         <parlamentare opp_id="167">
   *           <tipo>On</tipo>
   *           <nome>Angelino</nome>
   *           <cognome>ALFANO</cognome>
   *           <gruppo>
   *             <nome>Popolo delle Libertà</nome>
   *             <acronimo>PdL</acronimo>
   *           </gruppo>
   *           <data_inizio_carica>2008-04-29</data_inizio_carica>
   *           <circoscrizione>Sicilia 1</circoscrizione>
   *         </parlamentare>
   *       </primi_firmatari>
   *       <cofirmatari>
   *
   *       </cofirmatari>
   *       <relatori>
   *         <parlamentare opp_id="1518">
   *           <tipo>Sen</tipo>
   *           <nome>Roberto</nome>
   *           <cognome>CENTARO</cognome>
   *           <gruppo>
   *             <nome>Popolo delle Libertà</nome>
   *             <acronimo>PdL</acronimo>
   *           </gruppo>
   *           <data_inizio_carica>2008-04-29</data_inizio_carica>
   *           <circoscrizione>Sicilia</circoscrizione>
   *         </parlamentare>
   *       </relatori>
   *       <commissioni_assegnatarie>
   *         <commissione tipo_sede="referente">Senato Commissione II Giustizia</commissione>
   *         <commissione tipo_sede="consultiva">Senato Commissione I Affari Costituzionali</commissione>
   *         <commissione tipo_sede="consultiva">Senato Commissione III Affari Esteri</commissione>
   *         <commissione tipo_sede="consultiva">Senato Commissione V Bilancio</commissione>
   *       </commissioni_assegnatarie>
   *       <url_fonte_ufficiale xlink:href="http://www.senato.it/leg/16/BGT/Schede/Ddliter/33809.htm"/>
   *       <testi_atto>
   *         <url_testo_atto xlink:href="http://www.senato.it/loc/link.asp?tipodoc=DDLPRES&amp;leg=16&amp;id=424336"/>        
   *       </testi_atto>
   *     </atto>
   *   </op:content>
   * </opp>
   *
   *       
   * Return error in case something's wrong
   * <opp xlmns="http://www.openpolis.it/2010/opp"
   *        xmlns:op="http://www.openpolis.it/2010/op"
   *   <op:error>Messaggio di errore</op:error>
   * </opp>
   * @return String
   * @author Guglielmo Celata
   **/
  public function executeAtto()
  {
    $key = $this->getRequestParameter('key');
    $id = $this->getRequestParameter('opp_id');
    $is_valid_key = deppApiKeysPeer::isValidKey($key);
    
    $storage_path = sfConfig::get('sf_root_cache_dir');
    $file_path = sprintf("%s/atti/%s.xml", $storage_path, $id);

    $resp_node = new SimpleXMLExtended(
      '<opp xmlns="'.$this->opp_ns.'" '.
            ' xmlns:op="'.$this->op_ns.'" '.
            ' xmlns:xlink="'.$this->xlink_ns.'" >'.
      '</opp>');

    $is_error = false;
    
    if ($is_valid_key)
    {

      // controllo esistenza del file
      if ($fp = @fopen($file_path, "r"))
      {
        // retrieve contenuto XML dalla cache
        sfContext::getInstance()->getLogger()->info("reading from cache: " . $file_path);
        $xmlContent = fread($fp, filesize($file_path));
        fclose($fp);

        // send xml to output
        $this->_send_output($xmlContent);
        return sfView::NONE;
      } 

      // estrazione informazioni
      $atto = OppAttoPeer::retrieveByPK($id);
      if ($atto) {
        
        $titulo = $atto->getTitolo();
        $data_pres = $atto->getDataPres('Y-m-d');
        $ramo = $atto->getRamo();
        $numero = $atto->getNumfase();
        $legislatura = $atto->getLegislatura();

    		// produzione xml
        $content_node = $resp_node->addChild('op:content', null, $this->op_ns);         
        $atto_node = $content_node->addChild('atto', null, $this->opp_ns);      
        $atto_node->addAttribute('opp_id', $id);

        $atto_node->addChild('legislatura', $legislatura);
        $atto_node->addChild('ramo', $ramo);
        $atto_node->addChild('numero', $numero);

        $titulo_node = $atto_node->addChild('titolo', null);
        $titulo_node->addCData($titulo);

        $atto_node->addChild('presentato_il', $data_pres);

    	  //tipo di iniziativa
    	  $tipo_iniziativa = '';
    	  if($atto->getIniziativa())
    	  {
    	    switch($atto->getIniziativa())
    	    {
    	      case '1':
    		      $tipo_iniziativa = 'Parlamentare';
    		      break;
    		    case '2':
              $tipo_iniziativa = 'di Governo';
    		      break;
    	      default:
    		      $tipo_iniziativa = 'Popolare';
    		      break;
    	    }
    	  }

    	  $primi_firmatari_node = $atto_node->addChild('primi_firmatari');
        $this->addFirmatari('P', $atto, $primi_firmatari_node);

    	  $relatori_node = $atto_node->addChild('relatori');
        $this->addFirmatari('R', $atto, $relatori_node);

    	  $co_firmatari_node = $atto_node->addChild('co_firmatari');
        $this->addFirmatari('C', $atto, $co_firmatari_node);

        $commissioni_node = $atto_node->addChild('commissioni_assegnatarie');
        $commissioni = $atto->getCommissioni();
        foreach ($commissioni as $commissione) {
          $tipo_sede = $commissione->getTipo();
          if ($tipo_sede != 'Consultiva')
          {
            if ($commissione->getOppSede()->getRamo()=='S') $sede_comm="Senato";
            else $sede_comm = "Camera";
          }

          $commissione_node = $commissioni_node->addChild('commissione', 
            $sede_comm . " Commissione " . $commissione->getOppSede()->getDenominazione());

          $commissione_node->addAttribute('tipo_sede', $tipo_sede);
        }

        $atto_node->addChild('tipo_iniziativa', $tipo_iniziativa);

        
      } 
      else 
      {
        $is_error = true;
        $resp_node->addChild('op:error', 'Nessun atto trovato per questo ID', $this->op_ns);                
      }
    } 
    else 
    {
      $is_error = true;
      $resp_node->addChild('op:error', 'Chiave di accesso non valida', $this->op_ns);      
    }

    // build xml content out of respNode
    $xmlContent = $resp_node->asXML(); 

    // write xml cache to file system (for non-error xml's)
    if (!$is_error) {
      $fp = @fopen($file_path, "w");
      sfContext::getInstance()->getLogger()->info("writing to cache: " . $file_path);
      fwrite($fp, $xmlContent);
      fclose($fp);
    }
    
    // send xml to output
    $this->_send_output($xmlContent);
    return sfView::NONE;
  }


  protected function addFirmatari($tipo, $atto, $firmatari_node)
  {
    if (!in_array($tipo, array('P', 'R', 'C'))) {
      throw new Exception('Il parametro tipo può valere P, R o C');
    }
    
	  $rs = OppAttoPeer::getRecordsetFirmatari($atto->getId(), $tipo);
	  while ($rs->next())
    {
      $id = $rs->getInt(1);
      $nome = $rs->getString(2);
      $cognome = $rs->getString(3);
      $gruppo_nome = $rs->getString(4);
      $gruppo_acronimo = $rs->getString(6);
      $data_firma = $rs->getDate(5, 'Y-m-d');
      $tipo_carica_id = $rs->getInt(7);
      $parlamentare_node = $firmatari_node->addChild('parlamentare');
      $parlamentare_node->addAttribute('opp_id', $id);
      if ($tipo_carica_id == 1)
        $parlamentare_node->addChild('tipo', 'On');
      if ($tipo_carica_id == 4 || $tipo_carica_id == 5)
        $parlamentare_node->addChild('tipo', 'Sen');
      $parlamentare_node->addChild('nome', $nome);
      $parlamentare_node->addChild('cognome', $cognome);
      if ($gruppo_nome || $gruppo_acronimo) {
        $gruppo_node = $parlamentare_node->addChild('gruppo');
        $gruppo_node->addChild('nome', $gruppo_nome);
        $gruppo_node->addChild('acronimo', $gruppo_acronimo);
      }
      $parlamentare_node->addChild('data_firma', $data_firma);
	  }
  }

  /**
   * API (protetta da una API key)
   * torna flusso xml con gli atti in un certo intervallo di date
   * progetto op_fb
   *
   *   <opp xmlns="http://www.openpolis.it/2010/opp"
   *          xmlns:op="http://www.openpolis.it/2010/op"
   *          xmlns:xlink="http://www.w3.org/1999/xlink">
   *     <op:content> 
   *       <atto opp_id="38631">
   *         <legislatura>16</legislatura>
   *         <ramo>S</ramo>
   *         <numero>1611</numero>
   *         <titolo><![CDATA[
   *           [Ddl intercettazioni] Norme in materia di intercettazioni telefoniche, telematiche e ambientali. Modifica della disciplina in materia di astensione del giudice e degli atti di indagine. Integrazione della disciplina sulla responsabilità amministrativa delle persone giuridiche
   *           ]]>
   *         </titolo>
   *         <presentato_il>2009-06-11</presentato_il>
   *       </atto>
   *       <atto opp_id="51055">
   *         <legislatura>16</legislatura>
   *         <ramo>DL</ramo>
   *         <numero>29/10</numero>
   *         <titolo><![CDATA[
   *           [Decreto salva liste] Interpretazione autentica di disposizioni del procedimento elettorale e relativa disciplina di attuazione (G.U. n. 54 del 06/03/2010) 
   *           ]]>
   *         </titolo>
   *         <presentato_il>2010-03-05</presentato_il>
   *       </atto>
   *       <atto opp_id="36235">
   *         <legislatura>16</legislatura>
   *         <ramo>C</ramo>
   *         <numero>2350</numero>
   *         <titolo><![CDATA[
   *           [Testamento biologico e cure di fine vita] Disposizioni in materia di alleanza terapeutica, di consenso informato e di dichiarazioni anticipate di trattamento 
   *           ]]>
   *         </titolo>
   *         <presentato_il>2009-04-01</presentato_il>
   *       </atto>
   *     </op:content>
   *   </opp>
   *
   *       
   * Return error in case something's wrong
   * <opp xlmns="http://www.openpolis.it/2010/opp"
   *       xmlns:op="http://www.openpolis.it/2010/op"
   *   <op:error>Messaggio di errore</op:error>
   * </opp>
   * @return String
   * @author Guglielmo Celata
   **/
  public function executeElencoAtti()
  {
    
    $data_inizio = $this->getRequestParameter('data_inizio');
    $data_fine = $this->getRequestParameter('data_fine');
    $ramo = null;
    if ($this->hasRequestParameter('ramo'))
      $ramo = $this->getRequestParameter('ramo');
    $tipo_atto = null;
    if ($this->hasRequestParameter('tipo_atto'))
      $tipo_atto = $this->getRequestParameter('tipo_atto');
    
    $key = $this->getRequestParameter('key');
    $is_valid_key = deppApiKeysPeer::isValidKey($key);

    $resp_node = new SimpleXMLExtended(
      '<opp xmlns="'.$this->opp_ns.'" '.
            ' xmlns:op="'.$this->op_ns.'" '.
            ' xmlns:xlink="'.$this->xlink_ns.'" >'.
      '</opp>');
      
    if ($is_valid_key)
    {
  		// start producing xml
      $content_node = $resp_node->addChild('op:content', null, $this->op_ns);         
      
      $atti = OppAttoPeer::getAttiInDateInterval($data_inizio, $data_fine, $ramo, $tipo_atto);

      $atti_node = $content_node->addChild('atti', null, $this->opp_ns);      
      $atti_node->addAttribute('n_atti', count($atti));
      
      foreach ($atti as $atto)
      {
        $titulo = $atto->getTitolo();
        $data_pres = $atto->getDataPres('Y-m-d');
        $ramo = $atto->getRamo();
        $numero = $atto->getNumfase();
        $legislatura = $atto->getLegislatura();


        $atto_node = $atti_node->addChild('atto', null, $this->opp_ns);
        $atto_node->addAttribute('opp_id', $atto->getId());

        $atto_node->addChild('legislatura', $legislatura);
        $atto_node->addChild('ramo', $ramo);
        $atto_node->addChild('numero', $numero);
        
        $tipo_atto = $atto_node->addChild('tipo_atto', $atto->getOppTipoAtto()->getDenominazione());
        // $tipo_atto->addAttribute('id', $atto->getTipoAttoId());

        $titulo_node = $atto_node->addChild('titolo', null);
        $titulo_node->addCData($titulo);

        $atto_node->addChild('presentato_il', $data_pres);
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




  /**
   * API (protetta da una API key)
   * torna flusso xml con i dati di una singola votazione
   * progetto op_kw
   *
   *  <opkw xmlns="http://www.openpolis.it/2010/opkw"
   *         xmlns:op="http://www.openpolis.it/2010/op"
   *         xmlns:op_location="http://www.openpolis.it/2010/op_location"
   *         xmlns:op_politician="http://www.openpolis.it/2010/op_politician"
   *         xmlns:xlink="http://www.w3.org/1999/xlink">
   *    <op:content> 
   *        <parlamentare xlink:href="parlamentari/12345.xml">
   *          <thumbnail xlink:href="parlamentari/thumb/332104.jpeg" width="40" height="53"/>
   *          <nome>NOME</nome>
   *          <cognome>COGNOME</cognome>
   *          <gruppo>
   *            <nome>NOME GRUPPO</nome>
   *            <acronimo>NOME GRUPPO</acronimo>
   *          </gruppo>
   *          <data_inizio_carica>2008-04-12</data_inizio_carica> ** solo se successiva a data inizio leg.
   *        </parlamentare>
   *    </op:content>
   *  </opkw>
   *
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
  public function executeParlamentare()
  {
    $key = $this->getRequestParameter('key');
    $id = $this->getRequestParameter('id');
    $is_valid_key = deppApiKeysPeer::isValidKey($key);

    $resp_node = new SimpleXMLElement(
      '<opkw xmlns="'.$this->opkw_ns.'" '.
            ' xmlns:op="'.$this->op_ns.'" '.
            ' xmlns:xlink="'.$this->xlink_ns.'" >'.
      '</opkw>');
      
    if ($is_valid_key)
    {
      // estrazione informazioni
      $politico = OppPoliticoPeer::retrieveByPK($id);
      $p = $politico->getMetaInfo();
      $dati_storici = $politico->getDatiStorici();
      $voti_chiave = $politico->getVotiChiave();
      
  		// produzione xml
      $content_node = $resp_node->addChild('op:content', null, $this->op_ns);         
      $parlamentare_node = $content_node->addChild('parlamentare', null, $this->opkw_ns);

      $parlamentare_node->addAttribute('id', $p['politico_id']);

      if ($p['tipo_carica_id'] == 1)
        $parlamentare_node->addAttribute('prefix', 'On.');
      if ($p['tipo_carica_id'] == 4 || $p['tipo_carica_id'] == 5)
        $parlamentare_node->addAttribute('prefix', 'Sen.');
        
      $parlamentare_node->addChild('nome', $p['nome']);
      $parlamentare_node->addChild('cognome', $p['cognome']);
      $parlamentare_node->addChild('circoscrizione', $p['circoscrizione']);

      $gruppo_node = $parlamentare_node->addChild('gruppo');
      $gruppo_node->addChild('nome', $p['gruppo_nome']);        
      $gruppo_node->addChild('acronimo', $p['gruppo_acronimo']);    

      if ($data_inizio = $p['data_inizio'] > '2008-04-29')
        $parlamentare_node->addChild('data_inizio', date('d/m/Y', strtotime(date($p['data_inizio']))));    
        
      // dati storici
      $dati_node = $parlamentare_node->addChild('dati_storici');
      foreach ($dati_storici as $data => $dati) {
        $storico_node = $dati_node->addChild('dato_storico');
        $storico_node->addAttribute('date', $data);
        $n_votazioni = $dati['presenze'] + $dati['assenze'] + $dati['missioni'];
        foreach (array('presenze', 'assenze', 'missioni', 'ribellioni') as $tipo_dato) {
          $storico_dato_node = $storico_node->addChild($tipo_dato);
          $storico_dato_node->addChild($tipo_dato, $dati[$tipo_dato]);
          if ($n_votazioni && in_array($tipo_dato, array('presenze', 'missioni', 'assenze')))
          {
            $storico_dato_node->addChild('percentuale', sprintf("%7.1f", 100.0 * $dati[$tipo_dato] / $n_votazioni));
            $storico_dato_node->addChild('totale', sprintf("%d", $n_votazioni));            
          }
          if ($dati['presenze'] > 0 && $tipo_dato == 'ribellioni')
          {
            $storico_dato_node->addChild('percentuale', sprintf("%7.1f", 100.0 * $dati[$tipo_dato] / $dati['presenze']));
            $storico_dato_node->addChild('totale', sprintf("%d", $dati['presenze']));            
          }
          
        }
      }

      // voti chiave
      $voti_chiave_node = $parlamentare_node->addChild('voti_chiave', null, $this->opkw_ns);
      foreach ($voti_chiave as $voto_chiave) {
        $votazione = $voto_chiave->getOppVotazione();
        $voto = $voto_chiave->getVoto();
        $voto_maggioranza = $votazione->getEsito();
        $href = sprintf("/votazioni/%d.xml", $votazione->getId());
        
        $voto_chiave_node = $voti_chiave_node->addChild('voto_chiave');
        $voto_chiave_node->addAttribute('xlink:href', $href, $this->xlink_ns);
        $voto_chiave_node->addAttribute('id', $votazione->getId());
        $titolo = $votazione->getTitoloAggiuntivo() ? $votazione->getTitoloAggiuntivo() : $votazione->getTitolo();
    		$titolo_voto_node = $voto_chiave_node->addChild('titolo', $titolo);
    		$voto_node = $voto_chiave_node->addChild('voto', $voto);
    		$voto_node = $voto_chiave_node->addChild('voto_maggioranza', ucfirst(strtolower($voto_maggioranza)));
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



  /**
   * API (protetta da una API key)
   * torna flusso xml con i dati di una singola votazione
   * progetto op_kw
   *
   *  <opkw xmlns="http://www.openpolis.it/2010/opkw"
   *         xmlns:op="http://www.openpolis.it/2010/op"
   *         xmlns:op_location="http://www.openpolis.it/2010/op_location"
   *         xmlns:op_politician="http://www.openpolis.it/2010/op_politician"
   *         xmlns:xlink="http://www.w3.org/1999/xlink">
   *    <op:content> 
   *      <votazione>
   *        <riferimenti>
   *          <atto xlink:href="http://parlamento.openpolis.it/votazione/32288"></atto>
   *          ...
   *        </riferimenti>
   *        <sorgente xlink:href="http://leg16.camera.it/resoconti/resoconto_votazioni.asp?idSeduta=313&resoconto=indice_votazioni" />
   *        <titolo>1 Titulo</titolo>
   *        <descrizione_wiki>La descrizione ...</descrizione_wiki>
   *        <data>28/04/2010</data>
   *        <ramo>Camera</ramo>
   *        <num_seduta>313</num_seduta>
   *        <dettagli_voto>
   *          <esito>respinto</esito>
   *          <favorevoli n="225" perc="50.1" />
   *          <contrari n="224" perc="49.9" />
   *          <astenuti n="0" perc="0.0" />
   *          <scarto n="1">
   *          <presenti n="449" perc="71.3" />
   *          <assenti n="103" perc="16.3" />
   *          <in_missione n="76" perc="12.1" />
   *          <voto_ribelli n_voti="3">
   *            <parlamentare>
   *              <nome>Giancarlo</nome>
   *              <cognome>ABELLI</cognome>
   *              <acronimo_gruppo>PDL</acronimo_gruppo>
   *              <voto>Contrario</voto>
   *              <voto_gruppo>Favorevole</voto_gruppo>
   *            </parlamentare>
   *            ...
   *          </voto_ribelli>
   *          <voto_gruppi>
   *            <gruppo>
   *              <nome>Gruppo misto</nome>
   *              <favorevoli n="11" />
   *              <contrari n="1">
   *              <astenuti n="0">
   *              <assenti n="13">
   *              <in_missione n="6">
   *            </gruppo>
   *            ...
   *          </voto_gruppi>
   *          <voto_parlamentari>
   *            <parlamentare xlink:href="/parlamentari/4573.xml">
   *              <nome>Giancarlo</nome>
   *              <cognome>ABELLI</cognome>
   *              <acronimo_gruppo>PDL</acronimo_gruppo>
   *              <voto>Contrario</voto>
   *            </parlamentare>
   *            ...
   *          </voto_parlamentari>
   *        </dettagli_voto>
   *      </votazione>
   *    </op:content>
   *  </opkw>
   *
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
  public function executeVotazione()
  {
    $key = $this->getRequestParameter('key');
    $id = $this->getRequestParameter('id');
    $is_valid_key = deppApiKeysPeer::isValidKey($key);

    $resp_node = new SimpleXMLElement(
      '<opkw xmlns="'.$this->opkw_ns.'" '.
            ' xmlns:op="'.$this->op_ns.'" '.
            ' xmlns:xlink="'.$this->xlink_ns.'" >'.
      '</opkw>');
      
    if ($is_valid_key)
    {
      // estrazione informazioni
      $votazione = OppVotazionePeer::retrieveByPK($id);
      $seduta = $votazione->getOppSeduta();
      $data = $seduta->getData('Y-m-d');
      $titulo = $votazione->getTitoloAggiuntivo() ? $votazione->getTitoloAggiuntivo() : $votazione->getTitolo();
      
      $favorevoli = $votazione->getFavorevoli();
      $contrari = $votazione->getContrari();
      $astenuti = $votazione->getAstenuti();
      $votanti = $votazione->getVotanti();
      $presenti = $votazione->getPresenti();
      $ribelli = $votazione->getRibelli();
      $favorevoli_perc = sprintf("%4.1f", 100.0 * $favorevoli / $votanti);
      $contrari_perc = sprintf("%4.1f", 100.0 * $contrari / $votanti);
      $astenuti_perc = sprintf("%4.1f", 100.0 * $astenuti / $votanti);
      
      $voto_gruppi = $votazione->getVotoGruppi($data);
      $voto_ribelli = $votazione->getVotoRibelli($data);
      $voto_parlamentari = $votazione->getVotoParlamentari($data);

  		// produzione xml
      $content_node = $resp_node->addChild('op:content', null, $this->op_ns);         
      $votazione_node = $content_node->addChild('votazione', null, $this->opkw_ns);      
      
      $dettagli_node = $votazione_node->addChild('dettagli_voto', null, $this->opkw_ns);

      $dettagli_node->addChild('data', $seduta->getData('d/m/Y'));
      $dettagli_node->addChild('ramo', $seduta->getRamo() == 'C'?'Camera':'Senato');
      $dettagli_node->addChild('n_votazione', $votazione->getNumeroVotazione());
      $dettagli_node->addChild('n_seduta', $seduta->getNumero());
      $dettagli_node->addChild('titolo', $titulo);

      $dettagli_node->addChild('esito', ucfirst(strtolower($votazione->getEsito())));
      
      
      $favorevoli_node = $dettagli_node->addChild('favorevoli', null);
      $favorevoli_node->addAttribute('n', $favorevoli);
      $favorevoli_node->addAttribute('perc', $favorevoli_perc);

      $contrari_node = $dettagli_node->addChild('contrari', null);
      $contrari_node->addAttribute('n', $contrari);
      $contrari_node->addAttribute('perc', $contrari_perc);

      $astenuti_node = $dettagli_node->addChild('astenuti', null);
      $astenuti_node->addAttribute('n', $astenuti);
      $astenuti_node->addAttribute('perc', $astenuti_perc);

      $presenti_node = $dettagli_node->addChild('presenti', null);
      $presenti_node->addAttribute('n', $presenti);

      $votanti_node = $dettagli_node->addChild('votanti', null);
      $votanti_node->addAttribute('n', $votanti);

      $ribelli_node = $dettagli_node->addChild('ribelli', null);
      $ribelli_node->addAttribute('n', $ribelli);
      
      // dettaglio voto dei gruppi
      $gruppi_node = $votazione_node->addChild('voto_gruppi', null, $this->opkw_ns);
      foreach ($voto_gruppi as $nome => $detail) {
        $gruppo_node = $gruppi_node->addChild('gruppo', null, $this->opkw_ns);
        $gruppo_node->addChild('nome', $nome, $this->opkw_ns);
        foreach ($detail as $key => $value) {
          $gruppo_node->addChild(strtolower(str_replace(' ', '_', $key)), $value, $this->opkw_ns);
        }
      }

      // dettaglio voto dei ribelli
      $ribelli_node = $votazione_node->addChild('voto_ribelli', null, $this->opkw_ns);
      $ribelli_node->addAttribute('n_voti', $votazione->getRibelli());
      foreach ($voto_ribelli as $cognome => $ribelle)
      {
        $parlamentare_node = $ribelli_node->addChild('parlamentare', null, $this->opkw_ns);
        $parlamentare_node->addAttribute('xlink:href', sprintf("/parlamentari/%d.xml", $ribelle['politico_id']), $this->xlink_ns);
        $parlamentare_node->addAttribute('id', $ribelle['politico_id']);
        
        $parlamentare_node->addChild('nome', $ribelle['politico_nome'], $this->opkw_ns);
        $parlamentare_node->addChild('cognome', $ribelle['politico_cognome'], $this->opkw_ns);
        $parlamentare_node->addChild('acronimo_gruppo', $ribelle['gruppo_acronimo'], $this->opkw_ns);
        $parlamentare_node->addChild('voto', $ribelle['voto']);
        $parlamentare_node->addChild('voto_gruppo', $ribelle['voto_gruppo']);
      }
      
      // dettaglio voto dei parlamentari
      $parlamentari_node = $votazione_node->addChild('voto_parlamentari', null, $this->opkw_ns);
      foreach ($voto_parlamentari as $p)
      {
        $parlamentare_node = $parlamentari_node->addChild('parlamentare', null, $this->opkw_ns);
        $parlamentare_node->addAttribute('xlink:href', sprintf("/parlamentari/%d.xml", $p['id']), $this->xlink_ns);
        $parlamentare_node->addAttribute('id', $p['id']);
        
        $parlamentare_node->addChild('nome', $p['nome'], $this->opkw_ns);
        $parlamentare_node->addChild('cognome', $p['cognome'], $this->opkw_ns);
        $parlamentare_node->addChild('nome_gruppo', $p['nome_gruppo'], $this->opkw_ns);
        $parlamentare_node->addChild('acronimo_gruppo', $p['acronimo_gruppo'], $this->opkw_ns);
        $parlamentare_node->addChild('voto', $p['voto']);
        $parlamentare_node->addChild('circoscrizione', $p['circoscrizione'], $this->opkw_ns);
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



  /**
   * API (protetta da una API key)
   * torna flusso xml con i voti in cui la maggioranza è stata battuta
   * progetto op_kw
   *
   *  <opkw xmlns="http://www.openpolis.it/2010/opkw"
   *         xmlns:op="http://www.openpolis.it/2010/op"
   *         xmlns:op_location="http://www.openpolis.it/2010/op_location"
   *         xmlns:op_politician="http://www.openpolis.it/2010/op_politician"
   *         xmlns:xlink="http://www.w3.org/1999/xlink">
   *    <op:content> 
   *      <voti_maggioranza_sotto n_voti="50">
   *        <voto xlink:href="/votazioni/32288.xml">
   *          <titolo>Titolo</titolo>
   *          <data>28/04/2010</data>
   *          <ramo>Camera</ramo>
   *          <num_seduta>313</num_seduta>
   *          <esito>respinto</esito>
   *          <voto_maggioranza>contrario</voto_maggioranza>
   *          <n_ribelli>34</n_ribelli>
   *        </voto>
   *        ...
   *      </voti_maggioranza_sotto>
   *    </op:content>
   *  </opkw>
   *
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
  public function executeElencoVotiMaggioranzaSotto()
  {
    $key = $this->getRequestParameter('key');
    $is_valid_key = deppApiKeysPeer::isValidKey($key);

    $resp_node = new SimpleXMLElement(
      '<opkw xmlns="'.$this->opkw_ns.'" '.
            ' xmlns:op="'.$this->op_ns.'" '.
            ' xmlns:xlink="'.$this->xlink_ns.'" >'.
      '</opkw>');
      
    if ($is_valid_key)
    {
  		// start producing xml
      $content_node = $resp_node->addChild('op:content', null, $this->op_ns);         
      
      $votazioni = OppVotazionePeer::getMaggioranzaSottoVotes();

      // voti con maggioranza sotto
      $voti_node = $content_node->addChild('voti_maggioranza_sotto', null, $this->opkw_ns);      
      $voti_node->addAttribute('n_voti', count($votazioni));
      
      foreach ($votazioni as $votazione)
      {
        $data = $votazione->getOppSeduta()->getData('d/m/Y');
        $ramo =  $votazione->getOppSeduta()->getRamo()=='C' ? 'Camera' : 'Senato';
        $n_seduta =  $votazione->getOppSeduta()->getNumero();
        $href = sprintf("/votazioni/%s.xml", $votazione->getId());
        $titulo = $votazione->getTitoloAggiuntivo() ? $votazione->getTitoloAggiuntivo() : $votazione->getTitolo();
        $esito = $votazione->getEsito();
        $n_ribelli = $votazione->getRibelli();

        $voto_node = $voti_node->addChild('voto', null, $this->opkw_ns);
        $voto_node->addAttribute('xlink:href', $href, $this->xlink_ns);
        $voto_node->addAttribute('id', $votazione->getId());
        $voto_node->addChild('data', $data);
        $voto_node->addChild('ramo', $ramo);
        $voto_node->addChild('n_seduta', $n_seduta);
        $voto_node->addChild('titolo', $titulo);
        $voto_node->addChild('esito', ucfirst(strtolower($esito)));
        $voto_node->addChild('n_ribelli', $n_ribelli);
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

  /**
   * API (protetta da una API key)
   * torna flusso xml con i voti chiave
   * progetto op_kw
   *
   *  <opkw xmlns="http://www.openpolis.it/2010/opkw"
   *         xmlns:op="http://www.openpolis.it/2010/op"
   *         xmlns:op_location="http://www.openpolis.it/2010/op_location"
   *         xmlns:op_politician="http://www.openpolis.it/2010/op_politician"
   *         xmlns:xlink="http://www.w3.org/1999/xlink">
   *    <op:content> 
   *      <voti_chiave n_voti="50">
   *        <voto xlink:href="/votazioni/32288.xml">
   *          <titolo>Titolo</titolo>
   *          <data>28/04/2010</data>
   *          <ramo>Camera</ramo>
   *          <num_seduta>313</num_seduta>
   *          <esito>respinto</esito>
   *          <n_ribelli>34</n_ribelli>
   *        </voto>
   *        ...
   *      </voti_chiave>
   *    </op:content>
   *  </opkw>
   *
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
  public function executeElencoVotiChiave()
  {
    $key = $this->getRequestParameter('key');
    $is_valid_key = deppApiKeysPeer::isValidKey($key);

    $resp_node = new SimpleXMLElement(
      '<opkw xmlns="'.$this->opkw_ns.'" '.
            ' xmlns:op="'.$this->op_ns.'" '.
            ' xmlns:xlink="'.$this->xlink_ns.'" >'.
      '</opkw>');
      
    if ($is_valid_key)
    {
  		// start producing xml
      $content_node = $resp_node->addChild('op:content', null, $this->op_ns);         
      
      $votazioni = OppVotazionePeer::getKeyVotes();

      // voti chiave
      $voti_node = $content_node->addChild('voti_chiave', null, $this->opkw_ns);      
      $voti_node->addAttribute('n_voti', count($votazioni));
      
      foreach ($votazioni as $votazione)
      {
        $data = $votazione->getOppSeduta()->getData('d/m/Y');
        $ramo =  $votazione->getOppSeduta()->getRamo()=='C' ? 'Camera' : 'Senato';
        $n_seduta =  $votazione->getOppSeduta()->getNumero();
        $href = sprintf("/votazioni/%s.xml", $votazione->getId());
        $titulo = $votazione->getTitoloAggiuntivo() ? $votazione->getTitoloAggiuntivo() : $votazione->getTitolo();
        $esito = $votazione->getEsito();
        $n_ribelli = $votazione->getRibelli();

        $voto_node = $voti_node->addChild('voto', null, $this->opkw_ns);
        $voto_node->addAttribute('xlink:href', $href, $this->xlink_ns);
        $voto_node->addAttribute('id', $votazione->getId());
        $voto_node->addChild('data', $data);
        $voto_node->addChild('ramo', $ramo);
        $voto_node->addChild('n_seduta', $n_seduta);
        $voto_node->addChild('titolo', $titulo);
        $voto_node->addChild('esito', ucfirst(strtolower($esito)));
        $voto_node->addChild('n_ribelli', $n_ribelli);
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
   *        <parlamentare xlink:href="/parlamentari/12345.xml">
   *          <thumbnail xlink:href="/parlamentari/thumb/332104.jpeg" width="40" height="53"/>
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
    $ramo = $this->getRequestParameter('ramo');
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
      
    if ($is_valid_key)
    {
  		// start producing xml
      $content_node = $resp_node->addChild('op:content', null, $this->op_ns);         

      // camera o senato
      if ($ramo == 'tutti')
        $rami = array('camera' => 'C', 'senato' => 'S');
      else
        $rami = array($ramo => strtoupper(substr($ramo, 0, 1)));

      foreach ($rami as $ramo_name => $ramo_code) {
        $ramo_node = $content_node->addChild($ramo_name, null, $this->opkw_ns);      

        // dato storico aggregato per tutto il ramo
        $ramo_storico_node = $ramo_node->addChild('ramo', null, $this->opkw_ns);
        $rs = OppPoliticianHistoryCachePeer::getKWRamoRS($ramo_code, $con);
        $cnt = 0;
        while ($rs->next()) {
          $cnt++;
          $r = $rs->getRow();
          $this->addRamoNode($ramo_storico_node, $r, $infotype);
        }

        // gruppi
        $gruppi_node = $ramo_node->addChild('gruppi', null, $this->opkw_ns);
        $n_gruppi = OppPoliticianHistoryCachePeer::countByDataRamoChiTipo($current_data, $ramo_code, 'G', $con);
        $rs = OppPoliticianHistoryCachePeer::getKWGruppoRSByDataRamo($current_data, $ramo_code, null, null, $con);
        $cnt = 0;
        while ($rs->next()) {
          $cnt++;
          $g = $rs->getRow();
          $this->addGruppoNode($gruppi_node, $g, $infotype, $cnt);
        }
        $gruppi_node->addAttribute('n_gruppi', $n_gruppi);

        // parlamentari
        $parlamentari_node = $ramo_node->addChild('parlamentari', null, $this->opkw_ns);
        $n_parlamentari = OppPoliticianHistoryCachePeer::countByDataRamoChiTipo($current_data, $ramo_code, 'P', $con);
        $rs = OppPoliticianHistoryCachePeer::getKWPoliticiRSByDataRamo($current_data, $ramo_code, $order_by, $order_type, $con);
        $cnt = 0;
        while ($rs->next()) {
          $cnt++;
          $p = $rs->getRow();
          $this->addParlamentareNode($parlamentari_node, $p, $infotype, $cnt);
        }
        $parlamentari_node->addAttribute('n_rappresentanti', $n_parlamentari);
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


  protected function addParlamentareNode($node, $p, $infotype, $n)
  {
    $parlamentare_node = $node->addChild('parlamentare');
    $parlamentare_node->addAttribute('n_prog', $n);
    $parlamentare_node->addAttribute('id', $p['politico_id']);
    $parlamentare_node->addAttribute('xlink:href', 
                                     sprintf("/parlamentari/%d.xml", $p['politico_id']), $this->xlink_ns);

    $width = 40; $height = 53;

    $image_node = $parlamentare_node->addChild('thumbnail');
    $image_node->addAttribute('xlink:href', 
                              sprintf("/parlamentari/thumb/%d.jpeg", $p['politico_id']), $this->xlink_ns);
    $image_node->addAttribute('width', $width);
    $image_node->addAttribute('height', $height);

    $parlamentare_node->addChild('nome', $p['nome']);
    $parlamentare_node->addChild('cognome', $p['cognome']);
    $parlamentare_node->addChild('circoscrizione', $p['circoscrizione']);

    $gruppo_node = $parlamentare_node->addChild('gruppo');
    $gruppo_node->addChild('nome', $p['gruppo_nome']);        
    $gruppo_node->addChild('acronimo', $p['gruppo_acronimo']);    
    
    if ($data_inizio = $p['data_inizio'] > '2008-04-29')
      $parlamentare_node->addChild('data_inizio', date('d/m/Y', strtotime(date($p['data_inizio']))));    

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
  
  public function addInfoIndice($node, $item, $prec = true)
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
  
  public function addInfoRibellioni($node, $item, $prec = true)
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
