<?php namespace Parser;
// Class: CS 4350 SLC Fall 19 21412
// Assignment: CS 4350 Final
// Project: final-Mem-Dixy
// Student: Clifford Peters

/**
 * Query HTML
 *
 * Modeled after the QuerySelector in HTML.
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
 */

/**
 * @see https://www.php.net/manual/en/regexp.reference.delimiters.php
 */
define('DELIMITER', "#");
/*
 * The following constants are for regular expressions.
 * I had these as one big string, but trying to escape
 * double and single quotes inside of a regular
 * expression and a PHP string at the same time was a
 * bit too much. So I just went with constants for
 * everything because, why not?
 */
/**
 * @see http://www.unicode.org/charts/PDF/U0000.pdf
 */
define('QUOTATION_MARK', "\"");
/**
 * @see http://www.unicode.org/charts/PDF/U0000.pdf
 */
define('APOSTROPHE', "'");
/**
 * @see http://www.unicode.org/charts/PDF/U0000.pdf
 */
define('LESS_THAN_SIGN', "<");
/**
 * @see http://www.unicode.org/charts/PDF/U0000.pdf
 */
define('EQUALS_SIGN', "=");
/**
 * @see http://www.unicode.org/charts/PDF/U0000.pdf
 */
define('GREATER_THAN_SIGN', ">");
/**
 * @see http://www.unicode.org/charts/PDF/U0000.pdf
 */
define('QUESTION_MARK', "?");
/**
 * @see http://www.unicode.org/charts/PDF/U0000.pdf
 */
define('ASTERISK', "*");
/**
 * @see http://www.unicode.org/charts/PDF/U0000.pdf
 */
define('FULL_STOP', ".");
/**
 * @see http://www.unicode.org/charts/PDF/U0000.pdf
 */
define('SOLIDUS', "/");
/**
 * @see http://www.unicode.org/charts/PDF/U0000.pdf
 */
define('LEFT_SQUARE_BRACKET', "[");
/**
 * @see http://www.unicode.org/charts/PDF/U0000.pdf
 */
define('REVERSE_SOLIDUS', "\\");
/**
 * @see http://www.unicode.org/charts/PDF/U0000.pdf
 */
define('RIGHT_SQUARE_BRACKET', "]");
/**
 * @see http://www.unicode.org/charts/PDF/U0000.pdf
 */
define('CIRCUMFLEX_ACCENT', "^");

/**
 * To be implemented by classes seeking specialized query selection.
 * @category   Parser
 * @package    WebCrawler
 * @author     Clifford Peters <cliffordpeters@mail.weber.edu>
 * @copyright  2019 Clifford Peters
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */
abstract class Query
{
    /**
     * @var string $html The HTML page or fragment to parse.
     */
    protected $html;

    /**
     * Query constructor.
     * Usage:
     * <code>
     * // Not able to call this constructor directly because it is abstract.
     * $query = Query('<div><a href="#">Link</a></div>');
     * </code>
     * @param string $html The HTML page or fragment to parse.
     */
    public function __construct(string $html)
    {
        $this->html = $html;
    }

    /**
     * Returns the first item from QuerySelectorAll.
     * Usage:
     * <code>
     * $result = QuerySelector('href');
     * </code>
     * @param string $name The name of the item to find.
     * @return mixed|null Returns first full match of this search.
     */
    public function QuerySelector(string $name)
    {
        $query = $this->QuerySelectorAll($name);
        if ($query == null) {
            return null;
        }
        return $query[0];
    }

    /**
     * Returns all items from QueryResult.
     * Usage:
     * <code>
     * $result = [];
     * $result = QuerySelectorAll('href');
     * </code>
     * @param string $name The name of the item to find.
     * @return mixed Returns all full matches of this search.
     */
    public abstract function QuerySelectorAll(string $name);

    /**
     * Is called by children to find a result in a document.
     * Usage:
     * <code>
     * $result = QueryResult('<div><a href="#">Link</a></div>', 'href');
     * </code>
     * @param string $document The HTML page or fragment to parse.
     * @param string $selector The regular expresion to use, without delimiters.
     * @return mixed|null Returns first full match of this search.
     */
    protected function QueryResult(string $document, string $selector)
    {
        $array = $this->QueryResultAll($document, $selector);
        if ($array == null) {
            return null;
        }
        return $array[0];
    }

    /**
     * Is called by children to find all results in a document.
     * Usage:
     * <code>
     * $result = QueryResult('<div><a href="#">Link</a></div>', 'href');
     * </code>
     * @param string $document The HTML page or fragment to parse.
     * @param string $selector The regular expresion to use, without delimiters.
     * @return array Returns all full matches of this search.
     */
    protected function QueryResultAll(string $document, string $selector)
    {
        $array = [];
        $matches = $this->MatchAll($document, $selector);
        $index = 0;
        foreach ($matches[0] as &$match) {
            $array[$index] = $match;
            $index += 1;
        }
        return $array;
    }

    /**
     * Uses a regular expressions to scan a document.
     * Usage:
     * <code>
     * $result = QueryResult('<div><a href="#">Link</a></div>', 'href');
     * </code>
     * @param string $document The HTML page or fragment to parse.
     * @param string $selector The regular expresion to use, without delimiters.
     * @return array Returns all full matches of this search.
     */
    private function MatchAll(string $document, string $selector)
    {
        $pattern = DELIMITER . $selector . DELIMITER;
        $subject = $document;
        $matches = [];
        $flags = PREG_PATTERN_ORDER;
        $offset = 0;
        preg_match_all($pattern, $subject, $matches, $flags, $offset);
        return $matches;
    }
}
