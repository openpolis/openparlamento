<?php

/**
 * Get link to the diff page between two revisions of a page
 *
 * @param string $page_name
 * @param int $revision
 *
 * @return string
 */
function link_to_diff($text, $page_name, $rev1, $rev2, $mode = 'inline')
{
  return link_to($text, 'nahoWiki/diff?page=' . $page_name . '&oldRevision=' . $rev1 . '&revision=' . $rev2 . '&mode=' . $mode);
}

/**
 * Get link for the discussion page of a page in the wiki
 *
 * @param string $text text of the link
 * @param string $page_name
 * @param int $revision
 *
 * @return string
 */
function link_to_raw_diff($text, $page_name, $rev1, $rev2, $mode = 'unified')
{
  return link_to($text, 'nahoWiki/diff?page=' . $page_name . '&oldRevision=' . $rev1 . '&revision=' . $rev2 . '&mode=' . $mode . '&raw=1');
}

/**
 * Get URL for a page in the wiki
 *
 * @param string $page_name
 * @param int $revision
 * @param boolean $absolute
 *
 * @return string
 */
function url_for_wiki($page_name, $revision = null, $absolute = false)
{
  $url = 'nahoWiki/view?page=' . $page_name;
  if (!is_null($revision)) {
    $url .= '&revision=' . $revision;
  }
  
  return url_for($url, $absolute);
}

/**
 * Get link for a page in the wiki
 *
 * @param string $text text of the link (if null, we create it from the pagename+revision)
 * @param string $page_name
 * @param array $options params added to the link (you can add a 'revision' option to specifiy the revision of the page you want to link to)
 *
 * @return string
 */
function link_to_wiki($text, $page_name, $options = array())
{
  $url = 'nahoWiki/view?page=' . $page_name;
  if (isset($options['revision'])) {
    $url .= '&revision=' . $options['revision'];
  }
  if (is_null($text)) {
    $text = htmlspecialchars(nahoWikiPagePeer::getBasename($page_name));
    if (isset($options['revision'])) {
      $text .= ' rev. ' . $options['revision'];
    }
  }
  
  return link_to($text,  $url, $options);
}

/**
 * Get URL for the presentation page of a user in the wiki
 *
 * @param string $username
 * @param int $revision
 * @param boolean $absolute
 *
 * @return string
 */
function url_for_wiki_user($username, $revision = null, $absolute = false)
{
  return url_for_wiki('user:' . $username, $revision, $absolute);
}

/**
 * Get link for the presentation page of a user in the wiki
 *
 * @param string $text text of the link
 * @param string $username
 * @param array $options params added to the link (you can add a 'revision' option to specifiy the revision of the page you want to link to)
 * @param int $revision
 *
 * @return string
 */
function link_to_wiki_user($text, $username, $options = array())
{
  return link_to_wiki($text, 'user:' . $username, $options);
}

/**
 * Get URL for the discussion page of a page in the wiki
 *
 * @param string $page_name
 * @param int $revision
 * @param boolean $absolute
 *
 * @return string
 */
function url_for_wiki_discuss($page_name, $revision = null, $absolute = false)
{
  return url_for_wiki('discuss:' . $page_name, $revision, $absolute);
}

/**
 * Get link for the discussion page of a page in the wiki
 *
 * @param string $text text of the link
 * @param string $page_name
 * @param array $options params added to the link
 * @param int $revision
 *
 * @return string
 */
function link_to_wiki_discuss($text, $page_name, $options = array())
{
  return link_to_wiki($text, 'discuss:' . $page_name, $options);
}

/**
 * Include (display) a wiki page
 *
 * Options that can be used :
 * - display_toc => false # Hide the Table of contents
 * - display_pagename => false # Hide the page name
 *
 * @param string $page_name fully qualified page name
 * @param array $options additional options
 * @param int $revision
 */
function include_wiki($page_name, $revision = null, $options = array())
{
  $options['pagename'] = $page_name;
  $options['revision'] = $revision;
  include_component('nahoWiki', 'content', $options);
}

/**
 * Returns XHTML content of a wiki page
 *
 * Options that can be used :
 * - display_toc => false # Hide the Table of contents
 * - display_pagename => false # Hide the page name
 *
 * @param string $page_name fully qualified page name
 * @param array $options additional options
 * @param int $revision
 */
function get_wiki($page_name, $revision = null, $options = array())
{
  $options['pagename'] = $page_name;
  $options['revision'] = $revision;
  return get_component('nahoWiki', 'content', $options);
}
