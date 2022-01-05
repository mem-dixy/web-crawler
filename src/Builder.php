<?php
// Class: CS 4350 SLC Fall 19 21412
// Assignment: CS 4350 Final
// Project: final-Mem-Dixy
// Student: Clifford Peters

/**
 * Object Builder
 *
 * Builds objects so other parts of the code wont have to.
 *
 * PHP version 7
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Utility
 * @package    WebCrawler
 * @author     Clifford Peters <cliffordpeters@mail.weber.edu>
 * @copyright  2019 Clifford Peters
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

use Extractor\Curl;
use Extractor\File;
use Parser\Attribute;
use Parser\Element;
use Utility\Database;
use Utility\Queue;
use Utility\URL;
use Web\Page;

require_once __DIR__ . "/Extractor/Curl.php";
require_once __DIR__ . "/Extractor/File.php";
require_once __DIR__ . "/Parser/Attribute.php";
require_once __DIR__ . "/Parser/Element.php";
require_once __DIR__ . "/Utility/Database.php";
require_once __DIR__ . "/Utility/Queue.php";
require_once __DIR__ . "/Utility/URL.php";
require_once __DIR__ . "/Web/Page.php";

/**
 * A static object initializer.
 * @category   Utility
 * @package    WebCrawler
 * @author     Clifford Peters <cliffordpeters@mail.weber.edu>
 * @copyright  2019 Clifford Peters
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */
class Builder
{
    /**
     * Extracts the 'href' attribute.
     * Usage:
     * <code>
     * $result = Builder::AttributeHref('<div><a href="#">Link</a></div>');
     * </code>
     * @param string $html The HTML page or fragment to parse.
     * @return mixed|null The result.
     */
    public static function AttributeHref(string $html)
    {
        $attribute = new Attribute($html);
        return $attribute->QuerySelector('href');
    }

    /**
     * Extracts all 'a' elements.
     * Usage:
     * <code>
     * $result = Builder::ElementAnchorAll('<div><a href="#">Link</a></div>');
     * </code>
     * @param string $html The HTML page or fragment to parse.
     * @return array The result.
     */
    public static function ElementAnchorAll(string $html)
    {
        $element = new Element($html);
        return $element->QuerySelectorAll('a');
    }

    /**
     * Builds a File Extractor.
     * Usage:
     * <code>
     * $result = Builder::File();
     * </code>
     * @return File The result.
     */
    public static function File()
    {
        return new File();
    }

    /**
     * Builds a new URL.
     * @param string $url The URL to exact data from.
     * Usage:
     * <code>
     * $result = Builder::Url('https://en.wikipedia.org/wiki/Fire');
     * </code>
     * @return URL The result.
     */
    public static function URL(string $url)
    {
        return new URL($url);
    }

    /**
     * Builds a new Database.
     * Usage:
     * <code>
     * $result = Builder::Database();
     * </code>
     * @return Database The result;
     */
    public static function Database()
    {
        $databae = new Database();
        return $databae;
    }

    /**
     * Builds a new Page.
     * Usage:
     * <code>
     * $result = Builder::Page('https://en.wikipedia.org/wiki/Fire');
     * </code>
     * @param string $url The URL to exact data from.
     * @return Page The result.
     */
    public function Page(string $url)
    {
        $extract = \Builder::Curl();
        //$extract = \Builder::File();
        $page = new Page($url, $extract);
        return $page;
    }

    /**
     * Builds a Curl Extractor.
     * Usage:
     * <code>
     * $result = Builder::Curl();
     * </code>
     * @return Curl The result.
     */
    public static function Curl()
    {
        return new Curl();
    }

    /**
     * Builds a new Page.
     * Usage:
     * <code>
     * $result = Builder::Queue(10);
     * </code>
     * @param int $limit The max size of the Queue.
     * @return Queue The result.
     */
    public function Queue(int $limit)
    {
        $queue = new Queue($limit);
        return $queue;
    }
}
