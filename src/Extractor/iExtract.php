<?php namespace Extractor;
// Class: CS 4350 SLC Fall 19 21412
// Assignment: CS 4350 Final
// Project: final-Mem-Dixy
// Student: Clifford Peters

/**
 * Web Page Extractor
 *
 * Useful for having different ways of extracting html from a web page.
 *
 * PHP version 7
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Extractor
 * @package    WebCrawler
 * @author     Clifford Peters <cliffordpeters@mail.weber.edu>
 * @copyright  2019 Clifford Peters
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

/**
 * Implement this to get content from a web page.
 * @category   Extractor
 * @package    WebCrawler
 * @author     Clifford Peters <cliffordpeters@mail.weber.edu>
 * @copyright  2019 Clifford Peters
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */
interface iExtract
{
    /**
     * Return the content from the url.
     * Usage:
     * <code>
     * // Not able to call this code directly because it is interface.
     * $extract = new iExtract($url);
     * $html = $extract->get_contents($url);
     * </code>
     * @param string $url The URL of the wob page.
     * @return mixed The HTML from the web page.
     */
    public function get_contents(string $url);
}
