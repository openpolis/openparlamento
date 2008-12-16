<?php
class wikifiableBehavior
{
  protected $was_new = false;
  
  public function preSave($object, $con)
  {
    $this->was_new = $object->isNew();
  }

  public function postSave($object, $con)
  {
    if ($this->was_new)
    {
      // add an automatic wiki description
      nahoWikiToolkit::add_wiki_description($object, 
                                            sfConfig::get(sprintf('propel_behavior_wikifiableBehavior_%s_prefix', 
                                                          get_class($object))),
                                            "Descrizione wiki, a cura degli utenti.", 
                                            "Creazione Automatica");
    }    
  }
  
  /**
   * remove the page related to the object (and all the revisione in cascade)
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public function preDelete($object, $con)
  {
    $prefix = sfConfig::get(sprintf('propel_behavior_wikifiableBehavior_%s_prefix', get_class($object)));
    $wiki_page = nahoWikiPagePeer::retrieveByName($prefix . "_" . $object->getId());
    $wiki_page->delete();
  }
}