<?php

/**
 * Subclass for representing a row from the 'tag' table.
 *
 *
 *
 * @package plugins.sfPropelActAsTaggableBehaviorPlugin.lib.model
 */
class Tag extends BaseTag
{
  public function __toString()
  {
    return $this->getTripleValue();
  }


  public function getModelsTaggedWith()
  {
    return TagPeer::getModelsTaggedWith($this->getName());
  }


  public function getRelated($options = array())
  {
    return TagPeer::getRelatedTags($this->getName());
  }


  public function getTaggedWith($options = array())
  {
    return TagPeer::getTaggedWith($this->getName(), $options);
  }
  
  
  public function getTopTerms()
  {
    $tt_objects = $this->getOppTagHasTtsJoinOppTeseott();
    $res = "";
    foreach ($tt_objects as $tt)
      $res = $tt->getOppTeseott()->getDenominazione() . ", ";
    
    return trim($res, " ,");
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
    $document->id = md5('Tag' . $id);
    $document->sfl_model = 'Tag';
    $document->sfl_type = 'model';

    $document->propel_id = $id;
    $document->triple_value = $this->getTripleValue();

    // ritorna il documento da aggiungere
    return $document;
  }
  
}


sfPropelBehavior::add(
  'Tag', 
  array('deppPropelActAsMonitorableBehavior' =>
        array('count_monitoring_users_field'  => 'NMonitoringUsers',  // refers to ArticlePeer::N_MONITORING_USERS
              'monitorer_model'               => 'OppUser',           // user profile model (to set the cache)
              'count_monitored_objects_field' => 'NMonitoredTags',    // refers to OppUser::N_MONITORING_TAGS
       )));

sfSolrPropelBehavior::getInitializer()->setupModel('Tag');