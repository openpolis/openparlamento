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
 * @version         SVN: $Id: sfMarkdown.class.php 4712 2007-07-25 07:46:57Z Simone.Carletti $
 */


/**
 * @see sfMarkdownException
 */
require_once 'sfMarkdownException.class.php';

/**
 * @see Markdown_Parser
 */
require_once sfConfig::get('sf_markdown_parser_lib');


/**
 * sfMarkdown is the core class of sfMarkdown plugin.
 *
 * It's a bridge between Symfony class standards and MarkdownExtra_Parser,
 * an excellent PHP parser for Markdown documents.
 *
 * PHP Markdown_Parser and MarkdownExtra_Parser are developed by Michel Fortin.
 * You can get a copy at http://www.michelf.com/projects/php-markdown/
 * along with examples and full documentation.
 *
 * @category        Plugins
 * @package         sfMarkdown
 * @author          Simone Carletti <weppos@weppos.net>
 * @copyright       2007 The Authors
 * @license         http://www.symfony-project.com/content/license.html
 */
class sfMarkdown extends MarkdownExtra_Parser
{
    /**
     * @todo    1. Convenient functions for i18n projects
     *          2. Set a default storage folder for source files,
     *             probably /data/sfMarkdown/<module>/<file>
     */

    /**
     * Class constructor
     *
     * @return  void
     */
    public function __construct()
    {
        $class = sfConfig::get('sf_markdown_parser', 'MardownExtra_Parser');
        if (!class_exists($class)) {
            throw new sfMarkdownException("Parser class '$class' doens't exists");
        }

        // call parent constructor
        parent::$class();
    }

    /**
     * Class destructor
     *
     * @return  void
     */
    public function __destruct()
    {
    }

    /**
     * Convert text to HTML
     *
     * This function converts given markdown text to HTML.
     *
     * @param   string  $text
     * @return  string
     */
    public function convert($text)
    {
        // parse, convert and return
        return $this->transform($text);
    }

    /**
     * Convert file to HTML
     *
     * This function converts the content of given file to HTML.
     * The file, obviously, should contain only Markdown text.
     *
     * @param   string  $file
     * @return  string
     * @throws  sfMarkdownException if $file isn't readable
     */
    public function convertFile($file)
    {
        // check whether file is readable
        if (!is_readable($file)) {
            throw new sfMarkdownException("Unable to read file '$file'");
        }

        $text = file_get_contents($file);

        // convert
        return $this->convert($text);
    }

    /**
     * Convert text to HTML
     *
     * This function converts given markdown text to HTML.
     * It's just a convenient static shortcut for sfMarkdown::convert()
     *
     * @param   string  $text
     * @return  string
     * @see     sfMarkdown::convert()
     * @static
     */
    public static function doConvert($text)
    {
        $parser = self::getParserInstance();

        // parse, convert and return
        return $parser->convert($text);
    }

    /**
     * Convert file to HTML
     *
     * This function converts the content of given file to HTML.
     * The file, obviously, should contain only Markdown text.
     * It's just a convenient static shortcut for sfMarkdown::convertFile()
     *
     * @param   string  $file
     * @return  string
     * @throws  sfMarkdownException if $file isn't readable
     * @see     sfMarkdown::convertFile()
     * @static
     */
    public static function doConvertFile($file)
    {
        $parser = self::getParserInstance();

        // convert
        return $parser->convertFile($file);
    }

    /**
     * Returns a Markdown Parser instance
     *
     * @return  mixed   Markdown parser instance
     */
    public static function getParserInstance()
    {
        static $parser;
        static $class = __CLASS__;

        // get parser instance
        if (!($parser instanceof $class)) {
            $parser = new $class;
        }

        return $parser;
    }
}


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
