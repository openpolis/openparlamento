<?php

/**
 * Subclass for representing a row from the 'opp_emendamento' table.
 *
 * 
 *
 * @package lib.model
 */ 
class OppEmendamento extends BaseOppEmendamento
{
  
  /**
   * estrae tutte le firme fino a una certa data
   *
   * @param string $data 
   * @return array di OppCaricaHasEmendamento
   * @author Guglielmo Celata
   */
  public function getFirme($data)
  {
    return OppCaricaHasEmendamentoPeer::getFirme($this->getId(), $data);
  }
  
  /**
   * estrae tutti gli iter di un emendamento fino a una certa data
   *
   * @param string $data 
   * @return array di OppIterHasEmendamento
   * @author Guglielmo Celata
   */
  public function getItinera($data)
  {
    return OppEmendamentoHasIterPeer::getItinera($this->getId(), $data);
  }
  
  
  public function getURLFonte()
  {
    if (strpos($this->url_fonte, "http://") === false) {
      $url = sfConfig::get('app_url_sito_camera', 'http://nuovo.camera.it/') . $this->url_fonte;
    } else
      $url = $this->url_fonte;
    
    return $url;
  }
  

  /**
   * retrieve the last record of the emendamento_has_iter table
   * for the given emendamento
   *
   * @return OppEmIter object
   * @author Guglielmo Celata
   */
  public function getLastStatus()
  {
    $c = new Criteria();
  	$c->add(OppEmendamentoHasIterPeer::EMENDAMENTO_ID, $this->getId());
  	$c->addJoin(OppEmendamentoHasIterPeer::EM_ITER_ID, OppEmIterPeer::ID);
  	$c->addDescendingOrderByColumn(OppEmendamentoHasIterPeer::DATA);
  	$c->addDescendingOrderByColumn(OppEmendamentoHasIterPeer::CREATED_AT);
  	return OppEmendamentoHasIterPeer::doSelectOne($c);
  }
  
  /**
   * retrieve the main atto (portante)
   *
   * @param Criteria $c 
   * @return OppAtto
   * @author Guglielmo Celata
   */
  public function getAttoPortante(Criteria $c = null)
  {
    if (is_null($c))
    {
      $c = new Criteria();
    }
    $c->add(OppAttoHasEmendamentoPeer::PORTANTE, 1);
    $c->add(OppAttoHasEmendamentoPeer::EMENDAMENTO_ID, $this->getId());
    $c->addJoin(OppAttoHasEmendamentoPeer::ATTO_ID, OppAttoPeer::ID);
    return OppAttoPeer::doSelectOne($c);
  }
  
  /**
   * retrieve the complete title, which is a concatenation of
   * [titolo_aggiuntivo] titolo
   *
   * @return String
   * @author Guglielmo Celata
   */
  public function getTitoloCompleto()
  {
    $t = "";
    if ($this->getTitoloAggiuntivo()) {
      $t = ' [' . $this->getTitoloAggiuntivo() . '] ';
    }
    else
      $t = $this->getTitolo();
    return $t;
  }
  
  
  public function getTestoCompleto()
  {
    $t = "";
    foreach ($this->getOppEmTestos() as $cnt => $text)
      $t .= $text->getTesto();
    return $t;
  }
  
  /**
   * return a shortened version of the original title (to avoid layout problems)
   *
   * @param string $length 
   * @return String
   * @author Guglielmo Celata
   */
  public function getShortenedTitle($length)
  {
    $titolo = $this->getTitolo();
    return Text::shorten($titolo, $length);
  }
    
    
  /**
   * torna l'oggetto Apache_Solr_Document da indicizzare
   *
   * @return Apache_Solr_Document
   * @author Guglielmo Celata
   */
  public function intoSolrDocument()
  {
    $document = new Apache_Solr_Document();
    
    $id = $this->getId();
    $document->id = md5('OppEmendamento' . $id);
    $document->sfl_model = 'OppEmendamento';
    $document->sfl_type = 'model';

    $document->propel_id = $id;
    $document->titolo = strtolower(strip_tags($this->getTitoloCompleto()));
 
    $document->testo = $this->getTestoCompleto();
    
    if ($this->getDataPres())
      $document->data_pres_dt = $this->getDataPres('%Y-%m-%dT%H:%M:%SZ');

    $document->created_at_dt = $this->getCreatedAt('%Y-%m-%dT%H:%M:%SZ');

    // ritorna il documento da aggiungere
    return $document;
  }
    
}

sfPropelBehavior::add(
  'OppEmendamento', 
  array('deppPropelActAsVotableBehavior' =>
        array('voting_range'    => 1,              
              'voting_fields'   => array(1 => 'UtFav', -1 => 'UtContr'),
              'neutral_position'=> false,
              'anonymous_voting'=> false,
              'clear_cache_after_update' => true )));

sfPropelBehavior::add(
  'OppEmendamento', 
  array('deppPropelActAsTaggableBehavior' => array()));

sfPropelBehavior::add(
  'OppEmendamento', 
  array('deppPropelActAsCommentableBehavior' =>
        array('count_cache_enabled'   => true,
              'count_cache_method'    => 'setNbCommenti')));
              
sfPropelBehavior::add(
  'OppEmendamento', 
  array('wikifiableBehavior' => 
        array('prefix' => 'emendamento',
              'default_description' => "Inserire qui una descrizione dell'emendamento.",
              'default_user_comment' => 'Creazione iniziale')));

sfSolrPropelBehavior::getInitializer()->setupModel('OppEmendamento');
