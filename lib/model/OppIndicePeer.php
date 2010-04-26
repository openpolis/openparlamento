<?php

/**
 * Classe base per i calcoli degli indici (attività, rilevanza atti e tag, ...)
 *
 * @package lib.model
 */ 
class OppIndicePeer
{

  public static $soglia_cofirme = 10;

  public static $opp_ns = 'http://www.openpolis.it/2010/opp';
  public static $op_ns = 'http://www.openpolis.it/2010/op';
  public static $xlink_ns = 'http://www.w3.org/1999/xlink';
  
  public static $filesystem;
  
 
  public static function getFileSystem()
  {
    if (self::$filesystem == null)
      self::$filesystem = new sfFileSystem();
      
    return self::$filesystem;
  }
 
  
  /**
   * genera una processing instruction per includere link all'xsl nell'xml
   *
   * @param string $xml_node 
   * @param string $name 
   * @param string $value 
   * @return void
   * @author Guglielmo Celata
   */
  protected static function addProcessingInstruction( $xml_node, $name, $value )
  {
      // Create a DomElement from this simpleXML object
      $dom_sxe = dom_import_simplexml($xml_node);
     
      // Create a handle to the owner doc of this xml
      $dom_parent = $dom_sxe->ownerDocument;
     
      // Find the topmost element of the domDocument
      $xpath = new DOMXPath($dom_parent);
      $first_element = $xpath->evaluate('/*[1]')->item(0);
     
      // Add the processing instruction before the topmost element           
      $pi = $dom_parent->createProcessingInstruction($name, $value);
      $dom_parent->insertBefore($pi, $first_element);
  }
  
  
  
  
  
}
