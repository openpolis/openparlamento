<?php
/*
 * This file is part of the openparlamento
 * 
 * @author Guglielmo Celata <guglielmo.celata@gmail.com>
 */
sfLoader::loadHelpers(array('Javascript', 'Tag', 'I18N'));

$response = sfContext::getInstance()->getResponse();

$css = '/deppPropelActAsVotableBehaviorPlugin/css/depp_voting';
$response->addStylesheet($css);


/**
 * Return the HTML code the div containing the voter tool
 * If the user has already voted, then a message appears
 * 
 * @param  BaseObject  $object   Propel object instance to vote
 * @param  string      $domid    unique css identifier for the block (div) containing the voter tool
 * @param  array       $options  Array of HTML options to apply on the HTML list
 * @return string
 **/
function depp_voting_block($object, $domid='depp-voter-block', $options = array())
{
  $response->addJavascript('prototype.js');
  return content_tag('div', depp_voter($object, $domid, '', $options), array('id' => $domid));
}

/**
 * Return the HTML code for an unordered list showing opinions that can be voted (AJAX)
 * If the user has already voted, then a message appears
 * 
 * @param  BaseObject  $object   Propel object instance to vote
 * @param  string      $domid    unique css identifier for the block (div) containing the voter tool
 * @param  string      $message  a message string to be displayed in the voting-message block
 * @param  array       $options  Array of HTML options to apply on the HTML list
 * @return string
 **/
function depp_voter($object, $domid='depp-voter-block', $message='', $options = array())
{


  if (is_null($object))
  {
    sfLogger::getInstance()->debug('A NULL object cannot be voted');
    return '';
  }
  
  $user_id = deppPropelActAsVotableBehaviorToolkit::getUserId();
  // anonymous votes
  if ( (is_null($user_id) || $user_id == '') && !$object->allowsAnonymousVoting())
  {
    return __('Anonymous voting is not allowed') . ", " . __('please') . " " . 
           link_to('login', '/login');
  }
  
  try
  {
    $options = _parse_attributes($options);
    if (!isset($options['id']))
    {
      $options = array_merge($options, array('id' => 'voting-items'));
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
    $token = deppPropelActAsVotableBehaviorToolkit::addTokenToSession($object_class, $object_id);


    // already voted 
    if ($object->hasBeenVotedByUser($user_id))
    {

      $message .=  "&nbsp;" . 
                   link_to_remote(__('Take your vote back'),
                      array('url'  => sprintf('deppVoting/unvote?domid=%s&token=%s', $domid, $token),
                            'update'  => $domid,
                            'script'  => true,
                            'complete' => visual_effect('appear', $domid).
                                          visual_effect('highlight', $domid)));
    } 

    
    $list_content = '';    
    
    for ($i=-1; $i <= 1; $i+=2)
    {
      $text  = ($i==1?'yes':'no');
      $label = sprintf(__('Vote %s!'), $text);
      if ($object->hasBeenVotedByUser($user_id))
      {
        $image_name = ($object->getUserVoting($user_id) == $i?"btn-voted-$text.png":"btn-non-voted-$text.png");  
        $list_content .= content_tag('li', image_tag($image_name, $label));
      }
      else
      {
        $list_content .= content_tag('li', link_to_remote(image_tag("btn-vote-$text.png", $label), 
                    array('url'      => sprintf('deppVoting/vote?domid=%s&token=%s&voting=%d', $domid, $token, $i),
                          'update'   => $domid,
                          'script'   => true,
                          'complete' => visual_effect('appear', $domid).
                                        visual_effect('highlight', $domid)), 
                    array('title'    => $label)));
      }
    }

    
    $results = get_component('deppVoting', 'votingDetails', 
                             array('object'  => $object));
    
    return content_tag('ul', $list_content, $options).
           content_tag('div', $message, array('id' => 'voting-message')).
           content_tag('div', $results, array('id' => 'voting-results'));
  }
  catch (Exception $e)
  {
    sfLogger::getInstance()->err('Exception catched from sf_rater helper: '.$e->getMessage());
  }
}

/**
 * Return the HTML code the div containing the voter tool
 * If the user has already voted, then a message appears
 * 
 * @param  BaseObject  $object   Propel object instance to vote
 * @param  string      $domid    unique css identifier for the block (div) containing the voter tool
 * @param  array       $options  Array of HTML options to apply on the HTML list
 * @return string
 **/
function depp_voting_block_no_ajax($object, $message = '', $options = array())
{
  return content_tag('div', depp_voter_no_ajax($object, $message, $options));
}

/**
 * Return the HTML code for an unordered list showing opinions that can be voted (no AJAX)
 * If the user has already voted, then a message appears
 * 
 * @param  BaseObject  $object   Propel object instance to vote
 * @param  string      $message  a message string to be displayed in the voting-message block
 * @param  array       $options  Array of HTML options to apply on the HTML list
 * @return string
 **/
function depp_voter_no_ajax($object, $message='', $options = array())
{

  if (is_null($object))
  {
    sfLogger::getInstance()->debug('A NULL object cannot be voted');
    return '';
  }
  
  $results = get_component('deppVoting', 'votingDetails', array('object'  => $object));
  
  $user_id = deppPropelActAsVotableBehaviorToolkit::getUserId();
  // anonymous votes
  if ( (is_null($user_id) || $user_id == '') && !$object->allowsAnonymousVoting())
  {
    $msg = link_to('effettua il login per votare', '/login');
    return content_tag('div', $msg, array('id' => 'voting-message')) . 
           content_tag('div', $results, array('id' => 'voting-results'));
  }
  
  try
  {
    $options = _parse_attributes($options);
    if (!isset($options['id']))
    {
      $options = array_merge($options, array('id' => 'voting-items'));
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
    $token = deppPropelActAsVotableBehaviorToolkit::addTokenToSession($object_class, $object_id);


    // already voted 
    if ($object->hasBeenVotedByUser($user_id))
    {
      $message .=  "&nbsp;" . 
                   link_to(__('Take your vote back'),
                           sprintf('deppVoting/unvoteNoAjax?token=%s', $token), 
                           array('post' => true));
    } 

    
    $list_content = '';    
    
    for ($i=1; $i >= -1; $i-=2)
    {
      $text  = ($i==1?'yes':'no');
      $label = sprintf(__('Vote %s!'), $text);
      if ($object->hasBeenVotedByUser($user_id))
      {
        $image_name = ($object->getUserVoting($user_id) == $i?"btn-voted-$text.png":"btn-non-voted-$text.png");  
        $list_content .= content_tag('li', image_tag($image_name, $label));
      }
      else
      {
        $list_content .= content_tag('li', 
                                     link_to(image_tag("btn-vote-$text.png", $label), 
                                             sprintf('deppVoting/voteNoAjax?token=%s&voting=%d', $token, $i),
                                             array('post' => true)));
      }
    }

    
    return content_tag('ul', $list_content, $options).
           content_tag('div', $message, array('id' => 'voting-message')).
           content_tag('div', $results, array('id' => 'voting-results'));
  }
  catch (Exception $e)
  {
    sfLogger::getInstance()->err('Exception catched from sf_rater helper: '.$e->getMessage());
  }
  
}
