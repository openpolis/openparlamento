<?php

/**
 * Subclass for performing query and update operations on the 'sf_simple_wiki_page' table.
 *
 * 
 *
 * @package plugins.nahoWikiPlugin.lib.model
 */ 
class PluginnahoWikiPagePeer extends BasenahoWikiPagePeer
{
  
  public static function pageNameFormat($full = true)
  {
    $chars = sfConfig::get('app_nahoWikiPlugin_pagename_format', 'a-z0-9\-_');
    $separator = sfConfig::get('app_nahoWikiPlugin_ns_separator', ':');
    $mask = '[' . $chars;
    if ($full) {
      $mask .= preg_quote($separator, '/') . '\.';
    }
    $mask .= ']+';
    
    return $mask;
  }
  
  public static function getBasename($page_name)
  {
    $ns_separator = sfConfig::get('app_nahoWikiPlugin_ns_separator', ':');
    $parts = explode($ns_separator, $page_name);
    
    return array_pop($parts);
  }
  
  public static function getNamespace($page_name)
  {
    $ns_separator = sfConfig::get('app_nahoWikiPlugin_ns_separator', ':');
    $parts = explode($ns_separator, $page_name);
    array_pop($parts);
    
    return implode($ns_separator, $parts);
  }
  
  public static function retrieveByName($name)
  {
    $c = new Criteria;
    $c->add(self::NAME, $name);
    
    return self::doSelectOne($c);
  }
  
  public static function retrieveByNames($names)
  {
    $c = new Criteria;
    $c->add(self::NAME, $names, Criteria::IN);
    
    return self::doSelect($c);
  }
  
  public static function retrieveByNameJoinAll($name)
  {
    $result = self::retrieveByNamesJoinAll(array($name));
    
    if (is_array($result) && count($result)) {
      return $result[0];
    } else {
      return null;
    }
  }
  
  public static function retrieveByNamesJoinAll($names)
  {
    $c = new Criteria;
    $c->add(self::NAME, $names, Criteria::IN);
    
    return nahoWikiRevisionPeer::doSelectJoinAll($c);
  }
  
}
