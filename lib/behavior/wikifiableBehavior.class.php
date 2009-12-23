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
    $prefix = sfConfig::get(sprintf('propel_behavior_wikifiableBehavior_%s_prefix', get_class($object)));
    $default_description = sfConfig::get(sprintf('propel_behavior_wikifiableBehavior_%s_default_description', 
                                         get_class($object)), 'Descrizione di default');
    $default_user_comment = sfConfig::get(sprintf('propel_behavior_wikifiableBehavior_%s_default_user_comment', 
                                         get_class($object)), 'Commento di default');
    if ($this->was_new)
    {
      // add an automatic wiki description (and user comment) to a new wikifiable item
      nahoWikiToolkit::add_wiki_description($object, $prefix, $default_description, $default_user_comment);
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
    if (!is_null($wiki_page))
      $wiki_page->delete();
  }
}