<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package sfLucenePlugin
 * @subpackage Filter
 * @author Carl Vondrick
 */
class sfLuceneRenderingFilter extends sfRenderingFilter
{
  public function execute($filterChain)
  {
    $filterChain->execute();

    $this->getContext()->getResponse()->sendContent();
  }
}