<?php namespace Web;
// Class: CS 4350 SLC Fall 19 21412
// Assignment: CS 4350 Final
// Project: final-Mem-Dixy
// Student: Clifford Peters

/**
 * Page Object
 *
 * Represents an HTML web page.
 *
 * PHP version 7
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Web
 * @package    WebCrawler
 * @author     Clifford Peters <cliffordpeters@mail.weber.edu>
 * @copyright  2019 Clifford Peters
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */

use Extractor\iExtract;

require_once __DIR__ . "/../Builder.php";

/**
 * Its main purpose is currently to extract links from a web page.
 * @category   Web
 * @package    WebCrawler
 * @author     Clifford Peters <cliffordpeters@mail.weber.edu>
 * @copyright  2019 Clifford Peters
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */
class Page
{
    /**
     * @var int $html The HTML page or fragment to parse.
     */
    private $html;
    /**
     * @var int $host The URL of this web page.
     */
    private $host;

    /**
     * Page constructor.
     * Usage:
     * <code>
     * $page = new Page('https://en.wikipedia.org/wiki/Fire');
     * </code>
     * @param string $url The URL to exact data from.
     */
    public function __construct(string $url, iExtract $extract)
    {
        $this->html = $extract->get_contents($url);
        $this->host = \Builder::URL($url);
    }

    /**
     * Parses the HTML on this web page and extract the links it contains.
     * Usage:
     * <code>
     * $page = new Page('https://en.wikipedia.org/wiki/Fire');
     * $links = $page->AnchorList();
     * </code>
     * @return array An array of links.
     */
    public function AnchorList()
    {
        $array = [];
        $list = \Builder::ElementAnchorAll($this->html);
        foreach ($list as &$item) {
            $href = \Builder::AttributeHref($item);
            if ($href != null) {
                $url = \Builder::URL($href);
                $url->inherit($this->host);
                $link = $url->ToString();
                $array[] = $link;
            }
        }
        return $array;
    }
}
