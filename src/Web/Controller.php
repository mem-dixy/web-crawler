<?php namespace Web;
// Class: CS 4350 SLC Fall 19 21412
// Assignment: CS 4350 Final
// Project: final-Mem-Dixy
// Student: Clifford Peters

/**
 * Controller
 *
 * Code to manage logic on web pages.
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

require_once __DIR__ . "/../Builder.php";

/**
 * Code goes here to not clog up the index page.
 * @category   Web
 * @package    WebCrawler
 * @author     Clifford Peters <cliffordpeters@mail.weber.edu>
 * @copyright  2019 Clifford Peters
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */
class Controller
{
    /**
     * Start a new crawler.
     * Usage:
     * <code>
     * Crawler::Crawl('https://en.wikipedia.org/wiki/Fire', 10, 30);
     * </code>
     * @param string $url The URL to parse data from.
     * @param int $max The maximum number of links to scan.
     * @param int $sec The amount of time before the it stops.
     */
    public static function Crawl(string $url, int $max, int $sec)
    {
        $time_start = microtime(true);
        $time_passed = 0;
        $queue = \Builder::Queue($max);
        $storage = \Builder::Database();
        $queue->Push($url);
        while ($queue->HasItems() && $time_passed < $sec) {
            $url = $queue->Pull();
            $page = \Builder::Page($url);
            $list = $page->AnchorList();
            $count = count($list);
            for ($index = 0; $index < $count && $time_passed < $sec; $index += 1) {
                $item = $list[$index];
                if (!$queue->Push($item)) {
                    $storage->insert(self::InsertQuery($url, $item));
                    self::WriteLine($url, $item);
                }
                $time_passed = microtime(true) - $time_start;
            }
            $time_passed = microtime(true) - $time_start;
        }
        $maxTime = $time_passed >= $sec;
        $maxItem = $queue->IsFull();
        $custom = '';
        self::StatusReport($maxTime, $maxItem, $custom);
    }

    /**
     * Build Insert query statement.
     * Usage:
     * <code>
     * $query = self::InsertQuery('https://en.wikipedia.org/wiki/Fire', 'https://en.wikipedia.org/wiki/Main_Page');
     * </code>
     * @param string $host The URL of the main page.
     * @param string $link A URL found on the page.
     * @return string The Query to insert into database.
     */
    private static function InsertQuery(string $host, string $link)
    {
        $query = "INSERT INTO `crawl` (`host`, `link`) VALUES('";
        $query = $query . $host;
        $query = $query . "', '";
        $query = $query . $link;
        $query = $query . "')";
        return $query;
    }

    /**
     * Prints out the link pair to the user.
     * Usage:
     * <code>
     * self::WriteLine('https://en.wikipedia.org/wiki/Fire', 'https://en.wikipedia.org/wiki/Main_Page');
     * </code>
     * @param string $host The URL of the main page.
     * @param string $link A URL found on the page.
     */
    private static function WriteLine(string $host, string $link)
    {
        echo "\t\t\t\t" . '<div class="input-group mb-3">' . PHP_EOL;
        echo "\t\t\t\t\t" . '<div class="input-group-prepend">' . PHP_EOL;
        echo "\t\t\t\t\t\t" . '<span class="input-group-text">' . $host . '</span>' . PHP_EOL;
        echo "\t\t\t\t\t" . '</div>' . PHP_EOL;
        echo "\t\t\t\t\t" . '<span class="form-control">' . PHP_EOL;
        echo "\t\t\t\t\t\t" . '<a href="' . $link . '">' . $link . '</a>' . PHP_EOL;
        echo "\t\t\t\t\t" . '</span>' . PHP_EOL;
        echo "\t\t\t\t" . '</div>' . PHP_EOL;;
        flush();
        ob_flush();
    }

    /**
     * Build Insert query statement.
     * Usage:
     * <code>
     * self::StatusReport(true, false);
     * </code>
     * @param bool $maxTime Have we exceeded the Max Time?
     * @param bool $maxItem Have we exceeded the Max Limit?
     */
    private static function StatusReport(bool $maxTime, bool $maxItem, string $custom)
    {
        echo "\t\t\t\t" . '<div class="input-group mb-3">' . PHP_EOL;
        echo "\t\t\t\t\t" . '<span class="form-control">' . PHP_EOL;
        echo "\t\t\t\t\t\t";
        if ($maxItem) {
            echo 'Max Items Reached';
        } else if ($maxTime) {
            echo 'Exceeded Max Time';
        } elseif ($custom != '') {
            echo $custom;
        } else {
            echo 'Process Complete';
        }
        echo PHP_EOL;
        echo "\t\t\t\t\t" . '</span>' . PHP_EOL;
        echo "\t\t\t\t" . '</div>' . PHP_EOL;;
    }

    /**
     * Start a new searcher.
     * Usage:
     * <code>
     * self::Search('en.wikipedia.org', 300);
     * </code>
     * @param string $host The partial URL to search the database with.
     * @param int $limit How many results we want to return.
     */
    public static function Search(string $host, int $limit)
    {
        $database = \Builder::Database();
        $query = self::SelectQuery($host, $limit);
        echo "<!--" . PHP_EOL;
        $result = $database->query($query);
        echo "-->" . PHP_EOL;
        if ($result) {
            while ($row = \mysqli_fetch_row($result)) {
                $url = $row[0];
                $item = $row[1];
                self::WriteLine($url, $item);
            }
        }
        $maxTime = false;
        $maxItem = false;
        $custom = 'Returned Rows: ' . mysqli_num_rows($result);
        self::StatusReport($maxTime, $maxItem, $custom);
    }

    /**
     * Build Select query statement.
     * Usage:
     * <code>
     * $query = self::SelectQuery('en.wikipedia.org', 300);
     * </code>
     * @param string $host The partial URL to search the database with.
     * @param int $limit How many results we want to return.
     * @return string The Query to insert into database.
     */
    private static function SelectQuery(string $host, int $limit)
    {
        $query = "SELECT * FROM `crawl` WHERE `host` LIKE '%";
        $query = $query . $host;
        $query = $query . "%' LIMIT ";
        $query = $query . $limit;
        return $query;
    }

}
