<?php
/*
 * (c) 2008 Jakub Zalas
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Web browser
 *
 * @package    zToolsPlugin
 * @subpackage lib
 * @author     Jakub Zalas <jakub@zalas.pl>
 * @version    SVN: $Id$
 */
class zWebBrowser extends sfWebBrowser
{
  /**
   * Returns response as XML
   *
   * If reponse is not a valid XML it is being created from
   * a DOM document which is being created from a text response
   * (this is the case for not valid HTML documents).
   *
   * @return SimpleXMLElement
   */
  public function getResponseXML()
  {
    try
    {
      $this->responseXml = parent::getResponseXML();
    }
    catch (Exception $exception)
    {
      $doc = new DOMDocument();
      
      $resp_str = $this->getResponseText();
      $resp_ar = explode("\n", $resp_str);

      // suppress error output
      libxml_use_internal_errors(true);
      $doc->loadHTML($resp_str);
      $this->responseXml = simplexml_import_dom($doc);

      // send errors to logger
      $errors = libxml_get_errors();
      foreach ($errors as $error) {
          sfLogger::getInstance()->warning('{zWebBrowser::getResponseXML} ' . $this->displayXMLError($error, $resp_ar));
      }
      libxml_clear_errors();

    }

    return $this->responseXml;
  }
  
  protected function displayXmlError($error, $xml_ar)
  {
      $return  = $xml_ar[$error->line - 1] . "\n";
      $return .= str_repeat('-', $error->column) . "^\n";

      switch ($error->level) {
          case LIBXML_ERR_WARNING:
              $return .= "Warning $error->code: ";
              break;
           case LIBXML_ERR_ERROR:
              $return .= "Error $error->code: ";
              break;
          case LIBXML_ERR_FATAL:
              $return .= "Fatal Error $error->code: ";
              break;
      }

      $return .= trim($error->message) .
                 "\n  Line: $error->line" .
                 "\n  Column: $error->column";

      if ($error->file) {
          $return .= "\n  File: $error->file";
      }

      return "$return\n\n--------------------------------------------\n\n";
  }
  
}