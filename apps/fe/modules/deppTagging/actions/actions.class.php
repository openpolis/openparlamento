<?php
require_once(dirname(__FILE__).'/../../../../../plugins/deppPropelActAsTaggableBehaviorPlugin/modules/deppTagging/lib/BasedeppTaggingActions.class.php');

/**
 * deppPropelActAsTaggableBehaviorPlugin actions. 
 * Feel free to override this class in your dedicated app module.
 *
 * @package    plugins
 * @subpackage deppPropelActAsTaggableBehaviorPlugin
 * @author     Guglielmo Celata
 */
class deppTaggingActions extends BasedeppTaggingActions
{

  public function executeTagsAutocomplete() {
		$this->my_str = $this->getRequestParameter('value');

		$c = new Criteria();
		$c->add(TagPeer::TRIPLE_VALUE, "%".$this->my_str."%", Criteria::LIKE);
		$c->setLimit(10);
		$this->tags = TagPeer::getAll($c, array('is_triple' => true, 
		                                        'return' => 'value'));

	}

  public function executeUsertagsAutocomplete() {
		$this->my_str = $this->getRequestParameter('value');

		$c = new Criteria();
		$c->add(TagPeer::TRIPLE_VALUE, $this->my_str."%", Criteria::LIKE);
		$c->setLimit(10);
		$this->tags = TagPeer::getAll($c, array('is_triple' => true, 
		                                        'return' => 'value'));

	}


  public function executeAddAjax()
  {
    // fetch request parameters and taggable content
    $content_id = $this->getRequestParameter('content_id');
    $content_peer = $this->getRequestParameter('content_type') . 'Peer';
    $content = call_user_func(array($content_peer, 'retrieveByPK'), $content_id);
    $usertags = strip_tags($this->getRequestParameter('usertags'));

    // transform tag values into triple names
    // add the tag to the associated tag pool
    if ($usertags != '')
    {
      $tags_names = $this->_getNamesFromValues($usertags);
      $content->addTag($tags_names);
      $content->save();      
    }

    $this->_fetchTags($content);
    $this->setTemplate('ajaxAssociatedTags');
  }



  public function executeAjaxRemoveTagFromAssociatedTags()
  {
    $isAjax = $this->getRequest()->isXmlHttpRequest();
    if (!$isAjax) return sfView::noAjax;

    // identify the content
    $content_id = $this->getRequestParameter('content_id');
    $content_peer = $this->getRequestParameter('content_type') . 'Peer';
    $content = call_user_func(array($content_peer, 'retrieveByPK'), $content_id);

    // remove the tag from the associated tag pool
    $tag_name = $this->getRequestParameter('tag_name');
    $content->removeTag($tag_name);
    $content->save();

    $this->_fetchTags($content);
    
    $this->setTemplate('ajaxAssociatedTags');
  }

  /**
   * transform a list of tag values into an array of tag names
   * the criterion is the following:
   * - a tag value that is not already among the triple_values in sf_tag, gets the user:tag ns and key
   * - a tag value that is already existing, gets its own ns and key
   *
   * it is assumed that the triple_value field is unique, which is not the case for the plugin,
   * but can safely be assumed so thanks to this function 
   * (no user will ever be able to insert an already existing tag with ns=user)
   *
   * @param  String
   * @return String
   * @author Guglielmo Celata
   **/
  private function _getNamesFromValues($values)
  {
    $tagvalues = explode(",", $values);
    $tagnames = array();
    foreach ($tagvalues as $tagvalue)
    {
      $c = new Criteria();
      $c->add(TagPeer::TRIPLE_VALUE, $tagvalue);
      $tag = TagPeer::doSelectOne($c);
      if ($tag instanceof Tag)
      {
        $tagnames []= $tag->getName();
      } else {
        $tagnames []= deppPropelActAsTaggableToolkit::transformTagStringIntoTripleString($tagvalue, 'user', 'tag');
      }
    }
    
    return implode(",", $tagnames);
    
  }

  private function _fetchTags($content)
  {
    // read some config parameters and defaults
    $anonymous_tagging =  sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsTaggableBehavior_%s_anonymous_tagging', 
              get_class($content)),
      sfConfig::get('app_deppPropelActAsTaggableBehaviorPlugin_anonymous_tagging', true));
    $allows_tagging_removal =  sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsTaggableBehavior_%s_allows_tagging_removal', 
              get_class($content)),
      sfConfig::get('app_deppPropelActAsTaggableBehaviorPlugin_allows_tagging_removal', 'all'));
    $tagging_removal_credentials =  sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsTaggableBehavior_%s_tagging_removal_credentials', 
              get_class($content)),
      sfConfig::get('app_deppPropelActAsTaggableBehaviorPlugin_tagging_removal_credentials', array()));


    // fetch the associated tags
    $this->tags = $content->getTags(array('is_triple' => true));

    // sono considerati teseo_tags tutti i tag con ns teseo e geoteseo
	  $teseo_tags = $content->getTags(array('is_triple' => true,
                                          'namespace' => 'teseo',
                                          'return'    => 'value'));

	  $geo_tags = $content->getTags(array('is_triple' => true,
                                        'namespace' => 'geoteseo',
                                        'return'    => 'value'));
    $this->teseo_tags = array_merge($teseo_tags, $geo_tags);


    // tag aggiunti da utenti reali (user_id in not null)
	  $this->user_tags = $content->getUserTags(array('is_triple' => true,
                                                   'return'    => 'value'));
                                                   
    // i removable_tags sono quelli aggiunti dagli utenti (di default)
    $this->removable_tags = $this->user_tags;
    
    // tag aggiunti dall'utente loggato e override eventuale dei removable_tags 
    // (se la configurazione lo prevede)
    $this->my_tags = array(); 
    $user = @sfContext::getInstance()->getUser();
    $user_id = deppPropelActAsTaggableToolkit::getUserId();
    if (!$anonymous_tagging && $user->isAuthenticated() &&
        !is_null($user_id) && $user_id !== '')
    {
  	  $this->my_tags = $content->getUserTags(array('is_triple' => true,
                                                   'return'    => 'value'),
                                                   $user_id);
      if ($allows_tagging_removal == 'self' &&
          !$user->hasCredential($tagging_removal_credentials, false))      
        $this->removable_tags = $this->my_tags;
    }
  }

}
