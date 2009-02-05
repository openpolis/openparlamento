<?php

/**
 * Subclass for representing a row from the 'sf_blog_tag' table.
 *
 * 
 *
 * @package plugins.sfSimpleBlogPlugin.lib.model
 */ 
class PluginsfSimpleBlogTag extends BasesfSimpleBlogTag
{
  public function __toString()
  {
    return $this->getTag();
  }
}
