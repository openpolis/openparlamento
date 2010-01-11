<?php

/**
 * Class that extends (mixins) the Tagging class
 * 
 * with functions related to the project
 * 
 *
 * @package openparlamento
 */ 
class OppTaggingExtension
{
  /**
   * propagate all tags assigned to an OppEmendamento object
   * to the related OppAtto objects
   *
   * @param string $object 
   * @param string $con 
   * @param string $affected_rows 
   * @return void
   * @author Guglielmo Celata
   */
  public function propagateTagsToRelatedAttos($object, $con, $affected_rows)
  {
    $taggable_model = $object->getTaggableModel();
    if ($taggable_model != 'OppEmendamento')
      return;
    $taggable_id = $object->getTaggableId();
    $tagged_obj = call_user_func_array(array($taggable_model . 'Peer', 'retrieveByPK'), array($taggable_id));
    $relatedAttos = $tagged_obj->getOppAttoHasEmendamentosJoinOppAtto();
    foreach ($relatedAttos as $cnt => $atto_em) {
      
      $atto = $atto_em->getOppAtto();
      
      $tags_objs = $tagged_obj->getTagsAsObjects();
      $names = array();
      foreach ($tags_objs as $cnt => $tag_obj) {
        $names []= $tag_obj->getName();
      }
      
      $atto->addTag($names);
      $atto->save();
      
      sfLogger::getInstance()->info('{OppTaggingExtension::propagateTagsToRelatedAttos}' . 
                                    sprintf('atto with id %d received the following tags: %s', 
                                            $atto->getId(), implode(",", $names)));      
    }
  }
}