<?php

/*
 * This file is part of the sfEmendPlugin.
 * 
 * (c) 2009 Guglielmo Celata <guglielmo@depp.it>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfEmendPlugin toolkit class
 *
 * @author   Guglielmo Celata <guglielmo@depp.it>
 */
class sfEmendToolkit
{

  /**
   * clean the comment text field from html, in order to use it as submitted text
   * uses the htmlpurifier library, or a simple strip_tags call, based on the app.yml config file
   *
   * @return String
   * @param  String - the text to be cleaned
   *
   * @author Guglielmo Celata
   * @see    http://htmlpurifier.org/
   **/
  static public function clean($text)
  {

    $allowed_html_tags = sfConfig::get('app_sfEmendPlugin_allowed_tags', array());
    $use_htmlpurifier = sfConfig::get('app_sfEmendPlugin_use_htmlpurifier', false);

    if ($use_htmlpurifier)
    {
      $htmlpurifier_path = sfConfig::get('app_sfEmendPlugin_htmlpurifier_path', 
                                         SF_ROOT_DIR.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'htmlpurifier'. 
                                         DIRECTORY_SEPARATOR .'library' .DIRECTORY_SEPARATOR 
                                         );
      require_once $htmlpurifier_path .  'HTMLPurifier.auto.php';
      
      $config = HTMLPurifier_Config::createDefault();
      $config->set('HTML', 'Doctype', 'XHTML 1.0 Strict');
      $config->set('HTML', 'Allowed', implode(',', array_keys($allowed_html_tags)));

      if (isset($allowed_html_tags['a']))
      {
        $config->set('HTML', 'AllowedAttributes', 'a.href');
        $config->set('AutoFormat', 'Linkify', true);
      }

      if (isset($allowed_html_tags['p']))
      {
        $config->set('AutoFormat', 'AutoParagraph', true);
      }

      $purifier = new HTMLPurifier($config);
      $clean_text = $purifier->purify($text);      
    } 
    else 
    {
      $allowed_html_tags_as_string = "";
      foreach ($allowed_html_tags as $tag)
      {
        $allowed_html_tags_as_string .= "$tag";        
      }
      $clean_text = strip_tags($text, $allowed_html_tags_as_string);
    }
    
    return $clean_text;
  }
  
}
