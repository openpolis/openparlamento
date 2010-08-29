<?php
/*
 * This file is part of  openparlamento
 * 
 * @author Guglielmo Celata <guglielmo.celata@gmail.com>
 */
sfLoader::loadHelpers(array('Tag', 'I18N'));

$response = sfContext::getInstance()->getResponse();

$css = 'depp_prioritising';
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
function depp_prioritising_block($object, $message = '', $options = array())
{
  return content_tag('div', depp_prioritiser($object, $message, $options));
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
function depp_prioritiser($object, $message='', $options = array())
{

  if (is_null($object))
  {
    sfLogger::getInstance()->debug('A NULL object cannot be prioritised');
    return '';
  }
  
  $user_id = sfContext::getInstance()->getUser()->getId();
  
  try
  {
    $options = _parse_attributes($options);
    if (!isset($options['id']))
    {
      $options = array_merge($options, array('id' => 'prioritising-items'));
    }

    $object_id = $object->getPrioritisableReferenceKey();
    
    $list_content = '';    
    
    for ($i=($object->allowsNullPriority()?0:1); $i<=$object->getMaxPriority(); $i++)
    {
      if ($object->getPriorityValue() == $i) 
      {
        $label = sprintf(__('Priority last set by user %d at %s'), $object->getPriorityLastUser(), $object->getPriorityLastUpdate('Y-m-d h:i'));
        $image_name = "btn-current-$i.png";  
        $list_content .= content_tag('li', image_tag($image_name, array('alt' => $i, 'title' => $label)),
                                     array('class' => 'current'));
      }
      else
      {
        $label = sprintf(__('Set priority to %d'), $i);
        $list_content .= content_tag('li', 
                                     link_to(image_tag("btn-$i.png", array('alt' => $i, 'title' => $label)), sprintf('deppPrioritising/prioritise?object_id=%d&object_model=%s&priority=%d', 
                                             $object->getId(), get_class($object), $i),
                                             array('post' => true)));
      }
    }

    
    return content_tag('ul', $list_content, $options).
           content_tag('div', $message, array('id' => 'priority-message'));
  }
  catch (Exception $e)
  {
    sfLogger::getInstance()->err('Exception catched from deppPrioritising helper: '.$e->getMessage());
  }
  
}
