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
class Attribute extends Query
{
    /**
     * Finds all attributes with a given name and extracts the value from the attribute.
     * Usage:
     * <code>
     * $attribute = new Attribute('<div><a href="#">Link</a></div>')
     * $href = $element->QuerySelectorAll('href');
     * </code>
     * @param string $name The name of the attribute to find.
     * @return array|mixed The value of the first attribute found.
     */
    public function QuerySelectorAll(string $name)
    {
        $attribute = $this->GetFullAttribute($name);
        $value = [];
        $index = 0;
        foreach ($attribute as &$item) {
            $result = $this->GetAttributeValue($item);
            $trim = substr($result, 1, -1);
            $value[$index] = $trim;
            $index += 1;
        }
        return $value;
    }

    /**
     * Finds all attributes with a given name.
     * Usage:
     * <code>
     * $result = $this->GetFullAttribute('href');
     * </code>
     * @param string $name The name of the attribute to find.
     * @return array Returns first attribute of this search.
     */
    private function GetFullAttribute(string $name)
    {
        // NAME=[\"\'][^\"\']*[\"\']
        return $this->QueryResultAll($this->html,
            $name
            . EQUALS_SIGN
            . LEFT_SQUARE_BRACKET
            . REVERSE_SOLIDUS
            . QUOTATION_MARK
            . REVERSE_SOLIDUS
            . APOSTROPHE
            . RIGHT_SQUARE_BRACKET
            . LEFT_SQUARE_BRACKET
            . CIRCUMFLEX_ACCENT
            . REVERSE_SOLIDUS
            . QUOTATION_MARK
            . REVERSE_SOLIDUS
            . APOSTROPHE
            . RIGHT_SQUARE_BRACKET
            . ASTERISK
            . LEFT_SQUARE_BRACKET
            . REVERSE_SOLIDUS
            . QUOTATION_MARK
            . REVERSE_SOLIDUS
            . APOSTROPHE
            . RIGHT_SQUARE_BRACKET
        );
    }

    /**
     * Extracts the value from the attribute.
     * Usage:
     * <code>
     * $result = $this->GetAttributeValue('href="#"');
     * </code>
     * @param string $html The HTML page or fragment to parse.
     * @return mixed|null The value of the attribute.
     */
    private function GetAttributeValue(string $html)
    {
        // [\"\'][^\"\']*[\"\']
        return $this->QueryResult($html,
            LEFT_SQUARE_BRACKET
            . REVERSE_SOLIDUS
            . QUOTATION_MARK
            . REVERSE_SOLIDUS
            . APOSTROPHE
            . RIGHT_SQUARE_BRACKET
            . LEFT_SQUARE_BRACKET
            . CIRCUMFLEX_ACCENT
            . REVERSE_SOLIDUS
            . QUOTATION_MARK
            . REVERSE_SOLIDUS
            . APOSTROPHE
            . RIGHT_SQUARE_BRACKET
            . ASTERISK
            . LEFT_SQUARE_BRACKET
            . REVERSE_SOLIDUS
            . QUOTATION_MARK
            . REVERSE_SOLIDUS
            . APOSTROPHE
            . RIGHT_SQUARE_BRACKET
        );
    }
}
