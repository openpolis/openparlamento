<?php
/*
 * This file is part of the sfLucenePlugin package
 * (c) 2007 Carl Vondrick <carlv@carlsoft.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * @package    sfLucenePlugin
 * @subpackage Helper
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
  include_component('sfLucene', 'pagerNavigation', array('pager' => $pager, 'radius' => $radius, 'category' => $category));
}

function include_search_categories($multiple = false)
{
  include_component('sfLucene', 'categories', array('multiple' => $multiple));
}

function has_search_categories()
{
  return (sfConfig::get('app_lucene_categories', true) ? true : false) && (count(sfLuceneToolkit::getApplicationInstance()->getCategories()) > 0);
}

function highlight_result_text($text, $query, $size = 200, $highlighter = '<strong class="highlight">%s</strong>')
{
  $h = new sfLuceneHighlighter($text);
  $h->addKeywordSlug($query);
  $h->addHighlighter($highlighter);
  $h->hasBody(false);
  $h->densityCrop($size);
  return $h->highlight();
}

function highlight_keywords($text, $keywords, $highlighter = '<strong class="highlight">%s</strong>')
{
  $h = new sfLuceneHighlighter($text);
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

  $query .= sfConfig::get('app_lucene_highlight_qs','sf_highlight').'=' . implode($keywords, ' ') . $suffix;

  return $query;
}

function select_for_search_categories($categories)
{
  $n_categories = array('0' => '--All--');

  $n_categories += array_combine($categories, $categories);

  return options_for_select($n_categories, 0);
}
