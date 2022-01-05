<?php namespace Utility;
// Class: CS 4350 SLC Fall 19 21412
// Assignment: CS 4350 Final
// Project: final-Mem-Dixy
// Student: Clifford Peters

/**
 * URL Builder
 *
 * Helps with Parsing and Building of URLs.
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

/**
 * Helps with managing URLs and their subcomponents.
 * @category   Utility
 * @package    WebCrawler
 * @author     Clifford Peters <cliffordpeters@mail.weber.edu>
 * @copyright  2019 Clifford Peters
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */
class URL
{
    /**
     * URL constructor.
     * Usage:
     * <code>
     * $url = new URL('http://username:password@hostname:9090/path?arg=value#anchor');
     * </code>
     * @param string $url A valid URL string.
     */
    public function __construct(string $url)
    {
        $this->scheme = parse_url($url, PHP_URL_SCHEME);
        $this->host = parse_url($url, PHP_URL_HOST);
        $this->port = parse_url($url, PHP_URL_PORT);
        $this->user = parse_url($url, PHP_URL_USER);
        $this->pass = parse_url($url, PHP_URL_PASS);
        $this->path = parse_url($url, PHP_URL_PATH);
        $this->query = parse_url($url, PHP_URL_QUERY);
        $this->fragment = parse_url($url, PHP_URL_FRAGMENT);
    }

    /**
     * Replaces missing data with values from another URL.
     * Usage:
     * <code>
     * $url = new URL('/path?arg=value#anchor');
     * $inherit = $url->inherit('http://username:password@hostname:9090')
     * </code>
     * @param URL $url A valid URL string.
     */
    public function inherit(URL $url)
    {
        if (empty($this->scheme)) {
            $this->scheme = $url->scheme;
        }
        if (empty($this->user)) {
            $this->user = $url->user;
        }
        if (empty($this->pass)) {
            $this->pass = $url->pass;
        }
        if (empty($this->host)) {
            $this->host = $url->host;
        }
        if (empty($this->port)) {
            $this->port = $url->port;
        }
        if (empty($this->path)) {
            $this->path = $url->path;
        }
    }

    /**
     * Makes the object a string again.
     * Usage:
     * <code>
     * $url = new URL('/path?arg=value#anchor');
     * $value = $url->ToString();
     * </code>
     * @return string The object as valid URL string.
     */
    public function ToString()
    {
        $url = '';
        if (!empty($this->scheme)) {
            $url .= $this->scheme . '://';
        }
        if (!empty($this->user)) {
            $url .= $this->user . ':';
        }
        if (!empty($this->pass)) {
            $url .= $this->pass . '@';
        }
        $url .= $this->host;
        if (!empty($this->port)) {
            $url .= ':' . $this->port;
        }
        if ((!empty($this->host) || !empty($this->port)) && $this->path[0] != '/') {
            $url .= '/';
        }
        $url .= $this->path;
        if (!empty($this->query)) {
            $url .= '?' . $this->query;
        }
        if (!empty($this->fragment)) {
            $url .= '#' . $this->fragment;
        }
        return $url;
    }
}
