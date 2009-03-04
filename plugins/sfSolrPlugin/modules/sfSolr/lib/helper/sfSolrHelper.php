<?php
/*
 * This file is part of the sfSolrPlugin package
 * (c) 2009 Guglielmo Celata <g.celata@depp.it>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    sfSolrPlugin
 * @subpackage Helper
 * @author     Guglielmo Celata <g.celata@depp.it>
 * @author     Carl Vondrick <carlv@carlsoft.net>
 */

function include_search_result($result, $query = null)
{
  include_partial($result->getInternalPartial(), array('result' => $result, 'query' => $query));
}

function include_search_controls($query = null)
{
  include_component(sfContext::getInstance()->getModuleName(), 'controls', array('query' => $query));
}

function include_search_pager($pager, $radius = 5, $category = null)
{
  include_component('sfSolr', 'pagerNavigation', array('pager' => $pager, 'radius' => $radius, 'category' => $category));
}

function highlight_result_text($text, $query, $size = 200, $highlighter = '<strong class="highlight">%s</strong>')
{
  $h = new sfSolrHighlighter($text);
  $h->addKeywordSlug($query);
  $h->addHighlighter($highlighter);
  $h->hasBody(false);
  $h->densityCrop($size);
  return $h->highlight();
}

function highlight_keywords($text, $keywords, $highlighter = '<strong class="highlight">%s</strong>')
{
  $h = new sfSolrHighlighter($text);
  $h->addKeywordSlug($keywords);
  $h->addHighlighter($highlighter);
  $h->hasBody(false);

  return $h->highlight();
}

function add_highlight_qs($query, $keywords)
{
  $keywords = preg_split('/\W+/u', $keywords, -1, PREG_SPLIT_NO_EMPTY);

  $suffix = '';

  if (preg_match('/(#\w+)$/u', $query, $matches, PREG_OFFSET_CAPTURE))
  {
    $query = substr($query, 0, $matches[0][1]);

    $suffix = $matches[0][0];
  }

  if (false === stripos($query, '?'))
  {
    $query .= '?';
  }
  else
  {
    $query .= '&';
  }

  $query .= sfConfig::get('app_solr_highlight_qs','sf_highlight').'=' . implode($keywords, ' ') . $suffix;

  return $query;
}

