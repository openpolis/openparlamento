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
 * @version         SVN: $Id: MarkdownHelper.php 4712 2007-07-25 07:46:57Z Simone.Carletti $
 */


/**
 * Convert Markdown text to HTML
 *
 * Right now, this is simply a bridge to sfMarkdown class static functions.
 * I have some interesting ideas for the future.
 *
 * @param   string  $text
 * @return  string
 * @see     sfMarkdown::doConvert()
 */
function convert_markdown_text($text)
{
    return sfMarkdown::doConvert($text);
}


/**
 * Convert Markdown file content to HTML
 *
 * Right now, this is simply a bridge to sfMarkdown class static functions.
 * I have some interesting ideas for the future.
 *
 * @param   string  $file
 * @return  string
 * @see     sfMarkdown::doConvertFile()
 */
function convert_markdown_file($file)
{
    return sfMarkdown::doConvertFile($file);
}


/**
 * Converts Markdown text to HTML and prints returned data
 *
 * @param   string  $text
 * @return  void
 * @see     convert_markdown_text()
 * @see     sfMarkdown::doConvert()
 */
function include_markdown_text($text)
{
    echo convert_markdown_text($text);
}


/**
 * Converts Markdown file content to HTML and prints returned data
 *
 * @param   string  $file
 * @return  string
 * @see     convert_markdown_file()
 * @see     sfMarkdown::doConvertFile()
 */
function include_markdown_file($file)
{
    echo convert_markdown_file($file);
}


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
