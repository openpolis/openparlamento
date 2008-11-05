<?php
/*
 * This file is part of the deppPropelActAsBookmarkableBehaviorPlugin
 * 
 * @author Guglielmo Celata <guglielmo.celata@gmail.com>
 */
sfLoader::loadHelpers(array('Javascript', 'Tag', 'I18N'));

$response = sfContext::getInstance()->getResponse();

$css = '/deppPropelActAsBookmarkableBehaviorPlugin/css/depp_bookmarking';
$response->addStylesheet($css);

$response->addJavascript('prototype.js');


/**
 * Return the HTML code the div containing the bookmarkr tool
 * If the user has already bookmarked, then a message appears
 * 
 * @param  BaseObject  $object   Propel object instance to bookmark
 * @param  string      $domid    unique css identifier for the block (div) containing the bookmarkr tool
 * @param  array       $options  Array of HTML options to apply on the HTML list
 * @return string
 **/
function depp_bookmarking_block($object, $domid='depp-bookmarkr-block', $options = array())
{
  return content_tag('div', depp_bookmarkr($object, $domid, '', $options), array('id' => $domid));
}

/**
 * Return the HTML code for an unordered list showing opinions that can be bookmarked
 * If the user has already bookmarked, then a message appears
 * 
 * @param  BaseObject  $object   Propel object instance to bookmark
 * @param  string      $domid    unique css identifier for the block (div) containing the bookmarkr tool
 * @param  string      $message  a message string to be displayed in the bookmarking-message block
 * @param  array       $options  Array of HTML options to apply on the HTML list
 * @return string
 **/
function depp_bookmarkr($object, $domid='depp-bookmarkr-block', $message='', $options = array())
{


  if (is_null($object))
  {
    sfLogger::getInstance()->debug('A NULL object cannot be bookmarked');
    return '';
  }
  
  $user_id = deppPropelActAsBookmarkableBehaviorToolkit::getUserId();
  // anonymous bookmarks
  if ( (is_null($user_id) || $user_id == '') && !$object->allowsAnonymousBookmarking())
  {
    return __('Anonymous bookmarking is not allowed') . ", " . __('please') . " " . 
           link_to('login', '/login');
  }
  
  try
  {
    $bookmarking_range = $object->getBookmarkingRange();
    
    $options = _parse_attributes($options);
    if (!isset($options['id']))
    {
      $options = array_merge($options, array('id' => 'bookmarking-items'));
    }

    
    if ($object instanceof sfOutputEscaperObjectDecorator)
    {
      $object_class = get_class($object->getRawValue());
    }
    else
    {
      $object_class = get_class($object);
    }
    $object_id = $object->getReferenceKey();
    $token = deppPropelActAsBookmarkableBehaviorToolkit::addTokenToSession($object_class, $object_id);


    // already bookmarked 
    if ($object->hasBeenBokmarkedByUser($user_id))
    {

      $message .=  "&nbsp;" . 
                   link_to_remote(__('Take your bookmark back'),
                      array('url'  => sprintf('deppBookmarking/unbookmark?domid=%s&token=%s', $domid, $token),
                            'update'  => $domid,
                            'script'  => true,
                            'complete' => visual_effect('appear', $domid).
                                          visual_effect('highlight', $domid)));
    } 


    
    $list_content = '';    
    for ($i=-1*$bookmarking_range; $i <= $bookmarking_range; $i++)
    {
      if ($i==0 && !$object->allowsNeutralPosition() ) continue;
      $text  = sprintf("[%d]", $i);
      $label = sprintf(__('Bookmark %d!'), $i);
      if ($object->hasBeenBokmarkedByUser($user_id) && $object->getUserBookmarking($user_id) == $i)
      {
        $list_content .= content_tag('li', $text);
      }
      else
      {
        $list_content .= 
          '  <li>'.link_to_remote($text, 
                      array('url'      => sprintf('deppBookmarking/bookmark?domid=%s&token=%s&bookmarking=%d', $domid, $token, $i),
                            'update'   => $domid,
                            'script'   => true,
                            'complete' => visual_effect('appear', $domid).
                                          visual_effect('highlight', $domid)), 
                      array('title'    => $label)).'</li>';        
      }
    }
    
    $results = get_component('deppBookmarking', 'bookmarkingDetails', 
                             array('object'  => $object));
    
    return content_tag('ul', $list_content, $options).
           content_tag('div', $message, array('id' => 'bookmarking-message')).
           content_tag('div', $results, array('id' => 'bookmarking-results'));
  }
  catch (Exception $e)
  {
    sfLogger::getInstance()->err('Exception catched from sf_rater helper: '.$e->getMessage());
  }
}
