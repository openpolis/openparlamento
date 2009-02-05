<?php

function get_tag_links($tags)
{
  $links = array();
  foreach($tags as $tag)
  {
    $links[] = link_to($tag, 'sfSimpleBlog/showByTag?tag='.$tag);
  } 
  
  return implode($links, ', ');
}

function link_to_post($post, $text = '', $postfix = null, $options = array())
{
  if(!$text)
  {
    $text = $post->getTitle();
  }
  return link_to($text, sfSimpleBlogTools::generatePostUri($post, $postfix), $options);
}

