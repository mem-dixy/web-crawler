<?php namespace Parser;
// Class: CS 4350 SLC Fall 19 21412
// Assignment: CS 4350 Final
// Project: final-Mem-Dixy
// Student: Clifford Peters

/**
 * Element Query HTML
 *
 * Finds one or many elements in an HTML document.
 *
 * PHP version 7
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Parser
 * @package    WebCrawler
 * @author     Clifford Peters <cliffordpeters@mail.weber.edu>
 * @copyright  2019 Clifford Peters
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @see        Query
 */

require_once "Query.php";

/**
 * Finds header tags or self closing tags only.
 * @category   Parser
 * @package    WebCrawler
 * @author     Clifford Peters <cliffordpeters@mail.weber.edu>
 * @copyright  2019 Clifford Peters
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */
class Element extends Query
{
    /**
     * Finds all elements with a given name.
     * Usage:
     * <code>
     * $element = new Element('<div><a href="#">Link</a></div>')
     * $div = $element->QuerySelectorAll('div');
     * $a = $element->QuerySelectorAll('a');
     * </code>
     * @param string $name The name of the element to find.
     * @return array The results from this Query.
     */
    public function QuerySelectorAll(string $name)
    {
        // <NAME[^>]*?>
        return $this->QueryResultAll($this->html,
            LESS_THAN_SIGN
            . $name
            . LEFT_SQUARE_BRACKET
            . CIRCUMFLEX_ACCENT
            . GREATER_THAN_SIGN
            . RIGHT_SQUARE_BRACKET
            . ASTERISK
            . QUESTION_MARK
            . GREATER_THAN_SIGN
        );
    }
}
