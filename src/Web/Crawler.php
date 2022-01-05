<?php namespace Web;

require_once(__DIR__ . "/../Utility/URL.php");
require_once(__DIR__ . "/../Utility/Queue.php");
require_once(__DIR__ . "/Page.php");


class Crawler
{
    public function __construct($url, $max, $sec)
    {
        $time_start = microtime(true);
        $time_now = 0;
        $time_passed = 0;

        $queue = new \Utility\Queue($max);
        $storage = new \Utility\Queue($max);

        $queue->Push($url);
        while ($queue->HasItems() && $time_passed < $sec) {
            $url = $queue->Pull();
            $storage->Push($url);
            $page = $this->NewPage($url);
            $page->AnchorList($queue);
            $time_now = microtime(true);
            $time_passed = $time_now - $time_start;
        }
        if ($url != null) {
            echo "\t\t\t\t" . '<div class="input-group mb-3">' . PHP_EOL;
            echo "\t\t\t\t\t" . '<span class="form-control">' . PHP_EOL;
            echo "\t\t\t\t\t\t";
            if ($time_passed >= $sec) {
                echo 'Exceeded Max Time';
            } else if ($queue->IsFull()) {
                echo 'Max Items Reached';
            } else {
                echo 'Process Complete';
            }
            echo PHP_EOL;
            echo "\t\t\t\t\t" . '</span>' . PHP_EOL;
            echo "\t\t\t\t" . '</div>' . PHP_EOL;;
        }
    }

    function NewPage($url)
    {
        $extract = \Builder::Curl($url);
        //$extract = \Builder::File($url);
        $page = new Page($url, $extract);
        return $page;
    }
}
