<?php

class nahoWikiToolkit
{

  /**
   * initialize a wiki page (with content and revision), for a given object
   *
   * @return void
   * @author Guglielmo Celata
   **/
  public static function add_wiki_description($object, 
                                              $name_prefix = "", 
                                              $description = "Wiki description", 
                                              $comment = "Comment")
  {
    if ($name_prefix == "") $name_prefix = get_class($object);
      
    $page = new nahoWikiPage();
    $page->setName($name_prefix . '_' . $object->getId());
    $page->setLatestRevision(1);
    $page->save();
  
    $content = new nahoWikiContent();
    $content->setContent($description);
    $content->save();
  
    $revision = new nahoWikiRevision();
    $revision->setNahoWikiPage($page);
    $revision->setNahoWikiContent($content);
    $revision->setRevision(1);
    $revision->setComment($comment);
    $revision->setUserName("admin");
    $revision->save();
  }

}
