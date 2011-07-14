<?php
/*
 * This file is part of  openparlamento
 * 
 * @author Guglielmo Celata <guglielmo.celata@gmail.com>
 */
sfLoader::loadHelpers(array('Tag', 'I18N'));

$response = sfContext::getInstance()->getResponse();

$css = 'depp_omnibus';
$response->addStylesheet($css);


/**
 * Return the HTML code the div containing the tool to mark the omnibus flag
 * 
 * @param  BaseObject  $object   Propel object instance to flag
 * @param  string      $domid    unique css identifier for the block (div) containing the tool
 * @param  array       $options  Array of HTML options to apply on the HTML list
 * @return string
 **/
function depp_omnibus_block($object, $message = '', $options = array())
{
  return content_tag('div', depp_omnibus_selector($object, $message, $options));
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
function depp_omnibus_selector($object, $message='', $options = array())
{

  if (is_null($object))
  {
    sfLogger::getInstance()->debug('A NULL object cannot be flagged as Omnibus');
    return '';
  }
  
  $user_id = sfContext::getInstance()->getUser()->getId();
  
  try
  {
    $options = _parse_attributes($options);
    if (!isset($options['id']))
    {
      $options = array_merge($options, array('id' => 'omnibus-flag'));
    }


    $object_is_omnibus = $object->getIsOmnibus();
    $object_will_be_omnibus = !$object_is_omnibus;
    
    $selector = ''; 
  
    if ($object_is_omnibus) {
      $status = "Questo atto &egrave; Omnibus";
      $label = "Marcalo come non-Omnibus";
    } else {
      $status = "Questo atto non &egrave; Omnibus";      
      $label = "Marcalo come Omnibus";
    }
    
    $selector .= link_to($label, 
                         sprintf('atto/setOmnibusStatus?id=%d&status=%d', 
                                 $object->getId(), $object_will_be_omnibus),
                         array('post' => true));

    return content_tag('div', $status) .
           content_tag('div', $selector, $options);
  }
  catch (Exception $e)
  {
    sfLogger::getInstance()->err('Exception catched from deppOmnibus helper: '.$e->getMessage());
  }
  
}
