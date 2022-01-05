<?php namespace Extractor;
// Class: CS 4350 SLC Fall 19 21412
// Assignment: CS 4350 Final
// Project: final-Mem-Dixy
// Student: Clifford Peters

/**
 * Curl Extractor
 *
 * Uses PHP curl_exec to get the web page.
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

require_once "iExtract.php";

/**
 * The contents of the "User-Agent: " header to be used in a HTTP request.
 */
define('USERAGENT', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

/**
 * Uses PHP curl_exec to get the web page.
 * @category   Extractor
 * @package    WebCrawler
 * @author     Clifford Peters <cliffordpeters@mail.weber.edu>
 * @copyright  2019 Clifford Peters
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */
class Curl implements iExtract
{
    /**
     * Return the content from the url.
     * Usage:
     * <code>
     * $extract = new Curl($url);
     * $html = $extract->get_contents($url);
     * </code>
     * @param string $url The URL of the wob page.
     * @return mixed The HTML from the web page.
     */
    public function get_contents(string $url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, USERAGENT);
        $html = curl_exec($curl);
        curl_close($curl);
        return $html;
    }
}
