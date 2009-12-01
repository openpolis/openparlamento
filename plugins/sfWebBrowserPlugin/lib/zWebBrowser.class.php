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
      $doc->loadHTML($this->getResponseText());
      $this->responseXml = simplexml_import_dom($doc);
    }

    return $this->responseXml;
  }
}