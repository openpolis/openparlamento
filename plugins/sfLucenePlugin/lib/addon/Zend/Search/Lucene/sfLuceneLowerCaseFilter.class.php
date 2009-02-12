<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Same as Zend LowerCase filter, but has an optional ability to use mb_* functions.
 * @package sfLucenePlugin
 * @subpackage Addon
 */
class sfLuceneLowerCaseFilter extends Zend_Search_Lucene_Analysis_TokenFilter_LowerCase
{
  protected $mbString = false;

  protected $encoding = null;

  public function __construct($mbString = false, $encoding = null)
  {
    $this->mbString = $mbString;
    $this->encoding = $encoding;
  }

  /**
   * Normalize Token or remove it (if null is returned)
   *
   * @param Zend_Search_Lucene_Analysis_Token $srcToken
   * @return Zend_Search_Lucene_Analysis_Token
   */
  public function normalize(Zend_Search_Lucene_Analysis_Token $srcToken)
  {
    if ($this->mbString)
    {
      $value = mb_strtolower( $srcToken->getTermText(), $this->encoding );
    }
    else
    {
      $value = strtolower( $srcToken->getTermText() );
    }

    $newToken = new Zend_Search_Lucene_Analysis_Token(
                                 $value,
                                 $srcToken->getStartOffset(),
                                 $srcToken->getEndOffset());

    $newToken->setPositionIncrement($srcToken->getPositionIncrement());

    return $newToken;
  }
}

