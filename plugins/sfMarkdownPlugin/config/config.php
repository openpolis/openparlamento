<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * sfMarkdown - A Symfony Plugin for parsing and dealing with Markdown content
 *
 * This file is part of the sfMarkdown package.
 * (c) 2007 Simone Carletti <weppos@weppos.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * PHP versions 5
 *
 * @category        Plugins
 * @package         sfMarkdown
 * @author          Simone Carletti <weppos@weppos.net>
 * @copyright       2007 The Authors
 * @license         http://www.symfony-project.com/content/license.html
 * @version         SVN: $Id: config.php 4712 2007-07-25 07:46:57Z Simone.Carletti $
 */


// Path to this plugin
sfConfig::set(  'sf_markdown_plugin_dir',
                sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'sfMarkdownPlugin');

// Path to PHP Markdown parser library
// See http://www.michelf.com/projects/php-markdown/
sfConfig::set(  'sf_markdown_parser_lib',
                sfConfig::get('sf_markdown_plugin_dir').DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'markdown.php');

// Markdown parser name
// Useful to switch between multiple parsers, if you can choose
// For example default PHP Markdown parser library provides a classic parser called Mardown_Parser
// and an extra parser called MardownExtra_Parser
sfConfig::set(  'sf_markdown_parser', 'MarkdownExtra_Parser');


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
