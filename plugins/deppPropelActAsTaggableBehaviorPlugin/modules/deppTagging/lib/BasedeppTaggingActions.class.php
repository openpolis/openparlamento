<?php
/**
 * deppPropelActAsTaggableBehaviorPlugin base actions.
 * 
 * @package    plugins
 * @subpackage deppPropelActAsTaggableBehaviorPlugin
 */
class BasedeppTaggingActions extends sfActions
{

  public function executeEditAjax()
  {
    // fetch request parameters and taggable content
    $content_id = $this->getRequestParameter('content_id');
    $content_peer = $this->getRequestParameter('content_type') . 'Peer';
    $content = call_user_func(array($content_peer, 'retrieveByPK'), $content_id);

    $tags_as_string = deppPropelActAsTaggableToolkit::getTagsAsString(strip_tags($this->getRequestParameter('usertags')));

    // a setTags remove the tags and add them back
    $content->setTags(tags_string);
    $content->save();

    // get all tags, forcing the cache override (directly from the DB)
    $tags = $content->getTags(array(), true);

    // if necessary, get users' tags
    $anonymous_tagging =  sfConfig::get(
      sprintf('propel_behavior_deppPropelActAsTaggableBehavior_%s_anonymous_tagging', 
              get_class($content)),
      sfConfig::get('app_deppPropelActAsTaggableBehaviorPlugin_anonymous_tagging', true));
    $user = @sfContext::getInstance()->getUser();

    $user_tags = array();
    $user_id = deppPropelActAsTaggableToolkit::getUserId();
    if (!$anonymous_tagging && $user->isAuthenticated() &&
        !is_null($user_id) && $user_id !== '')
    {
  	  $user_tags = $content->getUserTags(array(), $user_id);      
    } 	
    
    // set the value to be returned by AJAX
    // it's the visible string, with <spam> tags  
    $this->value = deppPropelActAsTaggableToolkit::getTagsAsTaggedString(
        array('other' => array_diff($tags, $user_tags),
              'user'  => $user_tags));
  }
  
  public function executeEditableTagsAutocomplete() {
		$this->my_str = $this->getRequestParameter('value');
		
		$c = new Criteria();
		$c->add(TagPeer::TRIPLE_VALUE, $this->my_str."%", Criteria::LIKE);
		$this->tags = TagPeer::getAll($c);
						
	}
	
  
}