<?php

/**
 * Subclass for performing query and update operations on the 'sf_simple_wiki_content' table.
 *
 * 
 *
 * @package plugins.nahoWikiPlugin.lib.model
 */ 
class PluginnahoWikiContentPeer extends BasenahoWikiContentPeer
{
  
  public static function doConvert($content)
  {
    if (class_exists('sfMarkdown')) {
      return sfMarkdown::doConvert($content);
    } else {
      return $content;
    }
  }
  
  public static function makeReplacements($replaces, $content)
  {
    foreach ($replaces as $replace) {
      if (is_array($replace['to'])) {
        $content = preg_replace_callback($replace['from'], $replace['to'], $content);
      } else {
        $content = preg_replace($replace['from'], $replace['to'], $content);
      }
    }
    
    return $content;
  }
  
  public static function preConvert($page, $content)
  {
    // Convert nahoWiki-specific internal links to a syntax compatible with the chosen wiki engine
    $content = self::convertInternalLinks($page, $content);
    $content = self::convertInterwikiLinks($content);
    
    // Regexp replacements
    $replaces = sfConfig::get('app_nahoWikiPlugin_replace_before', array());
    
    return self::makeReplacements($replaces, $content);
  }
  
  public static function postConvert($page, $html)
  {
    $replaces = sfConfig::get('app_nahoWikiPlugin_replace_after', array());
    
    // Add the rule to insert ID to titles (support for anchors)
    $replaces[] = array(
      'from' => '/<(h[1-6])( .*+)?>(.*?)<\/\1>/i',
      'to'   => array('self', 'callbackNameTitle')
    );
    
    // Add the rule to apply security filters
    $tags = sfConfig::get('app_nahoWikiPlugin_strip_tags', array('script', 'embed', 'object'));
    if (count($tags)) {
      $replaces[] = array(
        'from' => '/<(' . implode('|', $tags) . ')( .+?)?>.*?<\/\1>/i',
        'to'   => ''
      );
    }
    
    return self::makeReplacements($replaces, $html);
  }
  
  protected static function extractLinkReplacements($content, $masks, $pcre_masks)
  {
    $replaces = array(); // hash of string-replacements to make
    foreach ($masks as $mask) {
      // extract mask elements
      preg_match_all('/%(' . implode('|', array_keys($pcre_masks)) . ')%/', $mask, $elements);
      $elements = $elements[1];
      // convert the mask to preg-compatible one
      $mask = preg_quote($mask, '/');
      foreach ($pcre_masks as $mask_id => $pcre) {
        $mask = str_replace('%' . $mask_id . '%', '(' . $pcre . ')', $mask);
      }
      // extract all corresponding items
      preg_match_all('/' . $mask . '/i', $content, $items, PREG_SET_ORDER);
      // delete them from working copy of content
      $content = preg_replace('/' . $mask . '/', '', $content);
      foreach ($items as $item) {
        if (!isset($replaces[$item[0]])) {
          // We did not handle this link yet
          $name = $title = '';
          foreach ($elements as $i => $element) {
            // Initialize $name and $title found by regexp
            $$element = $item[$i+1];
          }
          // default values & required elements
          if (!$name) {
            continue;
          }
          @list($name, $anchor) = explode('#', $name, 2);
          $replaces[$item[0]] = array('name' => $name, 'title' => $title, 'anchor' => $anchor, 'link' => '#');
        }
      }
    }
    
    return $replaces;
  }
  
  protected static function makeLinkReplacements($content, $replaces, $link_model, $existing_page = null, $broken_link_model = null) {
    // make full-text replacements
    foreach ($replaces as $source => $replace) {
      if (@$replace['link']) {
        // use the good model in app.yml, depending on wether the page exists or not
        if (!is_null($existing_page) && !is_null($broken_link_model) && !isset($existing_page[$replace['name']])) {
          $destination = $broken_link_model;
        } else {
          $destination = $link_model;
        }
        // replace by the customized model
        $destination = str_replace(
          array('%name%', '%title%', '%link%', '%image%', '%alttext%'), 
          array($replace['name'], $replace['title'], $replace['link'], @$replace['image'], @$replace['alttext']),
          $destination);
        $content = str_replace($source, $destination, $content);
      }
    }
    
    return $content;
  }
  
  public static function convertInternalLinks($page, $content)
  {
    $masks = sfConfig::get('app_nahoWikiPlugin_internal_links', array('[[%name% %title%]]', '[[%name%]]'));
    $pcre_masks = array(
      'name'  => nahoWikiPagePeer::pageNameFormat() . '(?:#[A-Za-z0-9_\-]+)?',
      'title' => '.*?',
    );
    
    $replaces = self::extractLinkReplacements($content, $masks, $pcre_masks);
    
    // Extract names and complete the replacements array
    $names = array();
    $controller = sfContext::getInstance()->getController();
    foreach ($replaces as &$replace) {
      // Full name
      $replace['name'] = $page->resolveAbsoluteName($replace['name']);
      // Title
      if (!$replace['title']) {
        $replace['title'] = nahoWikiPagePeer::getBasename($replace['name']);
      }
      // Link
      $url = 'nahoWiki/view?page=' . $replace['name'];
      if (@$replace['anchor']) {
        $url .= '#' . $replace['anchor'];
      }
      $replace['link'] = $controller->genUrl($url, false);
      // Store name
      $names[] = $replace['name'];
    }
    
    // Find all existing pages
    $existing_page = array();
    $pages = nahoWikiPagePeer::retrieveByNames($names);
    foreach ($pages as $page) {
      $existing_page[$page->getName()] = true;
    }
    
    $link_model = sfConfig::get('app_nahoWikiPlugin_internal_link_model', '[%title%](%link%)');
    $broken_link_model = sfConfig::get('app_nahoWikiPlugin_internal_link_broken_model', '[%title%(?)](%link%)');
    
    return self::makeLinkReplacements($content, $replaces, $link_model, $existing_page, $broken_link_model);
  }
  
  public static function convertInterwikiLinks($content)
  {
    $masks = sfConfig::get('app_nahoWikiPlugin_interwiki_links', array('[[%name% %title%]]', '[[%name%]]'));
    $pcre_masks = array(
      'name'  => '[a-z]+>' . nahoWikiPagePeer::pageNameFormat() . '(?:#[A-Za-z0-9_\-]+)?',
      'title' => '.*?',
    );
    
    $replaces = self::extractLinkReplacements($content, $masks, $pcre_masks);
    
    // Complete the replacements array
    $interwiki = sfConfig::get('app_nahoWikiPlugin_interwiki', array());
    $web_root = sfContext::getInstance()->getRequest()->getRelativeUrlRoot();
    $dir_root = sfConfig::get('sf_web_dir');
    $plugin_dir = '/nahoWikiPlugin/images/';
    foreach ($replaces as &$replace) {
      list($key, $name) = explode('>', $replace['name'], 2);
      if (isset($interwiki[$key])) {
        $replace['link'] = $interwiki[$key] . rawurlencode($name);
        if ($replace['link']) {
          $replace['alttext'] = $key;
          $key = strtolower($key);
          if (is_file($dir_root . ($image = $plugin_dir . 'interwiki/' . $key . '.png'))) {
            $replace['image'] = $web_root . $image;
          } elseif (is_file($dir_root . ($image = $plugin_dir . 'interwiki/' . $key . '.gif'))) {
            $replace['image'] = $web_root . $image;
          } elseif (is_file($dir_root . ($image = $plugin_dir . 'interwiki/' . $key . '.jpg'))) {
            $replace['image'] = $web_root . $image;
          } else {
            $replace['image'] = $web_root . $plugin_dir . 'interwiki.png';
          }
        }
        if (!$replace['title']) {
          $replace['title'] = $name;
        }
      }
    }
    
    $link_model = sfConfig::get('app_nahoWikiPlugin_interwiki_link_model', '[![%alttext%](%image%) %title%](%link%)');
    
    return self::makeLinkReplacements($content, $replaces, $link_model);
  }

  public static function titleToID($title)
  {
    if (function_exists('mb_detect_encoding') && function_exists('mb_convert_encoding')) {
      $id = mb_convert_encoding($title, 'HTML-ENTITIES', mb_detect_encoding($title));
    } else {
      $id = htmlentities($title);
    }
    // remove accents
    $id = preg_replace('/&(.*?)(cedil|circ|acute|grave|tilde|uml|lig);/', '$1', $id);
    // remove remaining entities
    $id = preg_replace('/&[^;]*;/', '_', $id);
    // remove non alphanumeric characters
    $id = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $id);
    // Lowerize
    $id = strtolower($id);
    
    return $id;
  }
  
  public static function callbackNameTitle($matches)
  {
    $title = $matches[3];
    $id = self::titleToID($title);
    
    return '<'. $matches[1] . $matches[2] . ' id="' . htmlentities($id) . '">' . $title . '</' . $matches[1] . '>';
  }
  
  public static function addToTOC(&$toc, $title, $deepness = 1)
  {
    if ($deepness > 1) {
      if (!($n = count($toc))) {
        $toc[] = array('title' => '', 'id' => '', 'subtitles' => array());
        $i = 0;
      } else {
        $i = $n - 1;
      }
      self::addToTOC($toc[$i]['subtitles'], $title, $deepness - 1);
    } else {
      $toc[] = array('title' => $title, 'id' => self::titleToID($title), 'subtitles' => array());
    }
  }
  
  public static function getTOC($html)
  {
    $toc = array();
    preg_match_all('/<h([1-6]).*?>(.*?)<\/h\1>/i', $html, $matches, PREG_SET_ORDER);
    foreach ($matches as $match) {
      self::addToTOC($toc, $match[2], intval($match[1]));
    }
    
    return $toc;
  }
  
}
