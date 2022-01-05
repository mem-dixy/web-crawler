<?php namespace Utility;
// Class: CS 4350 SLC Fall 19 21412
// Assignment: CS 4350 Final
// Project: final-Mem-Dixy
// Student: Clifford Peters

/**
 * Queue Manager
 *
 * A first in first out container.
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
 * A first in first out container.
 * @category   Utility
 * @package    WebCrawler
 * @author     Clifford Peters <cliffordpeters@mail.weber.edu>
 * @copyright  2019 Clifford Peters
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 */
class Queue
{
    /**
     * @var array $array The container to hold the data.
     */
    private $array;
    /**
     * @var int $index The first item of the container.
     */
    private $index;
    /**
     * @var int $count The last item of the container.
     */
    private $count;
    /**
     * @var int $limit The maximum capacity of this container.
     */
    private $limit;

    /**
     * Queue constructor.
     * Usage:
     * <code>
     * $queue = new Queue(70);
     * </code>
     * @param int $limit The maximum capacity of this container.
     */
    public function __construct(int $limit)
    {
        $this->array = [];
        $this->index = 0;
        $this->count = 0;
        $this->limit = $limit;
    }

    /**
     * Adds an item to the Queue.
     * Usage:
     * <code>
     * $queue = new Queue(70);
     * $full = $queue->Push('A puppy');
     * </code>
     * @param string $item An item to add to the container.
     * @return bool True if the container is full.
     */
    public function Push(string $item)
    {
        $full = $this->IsFull();
        if (!$full) {
            $this->array[$this->count] = $item;
            $this->count += 1;
        }
        return $full;
    }

    /**
     * Used to check if the queue is full.
     * Usage:
     * <code>
     * $queue = new Queue(70);
     * $queue->Push('A puppy');
     * $test = $queue->IsFull();
     * </code>
     * @return bool True if limit has been reached.
     */
    public function IsFull()
    {
        return $this->count > $this->limit;
    }

    /**
     * Removes an item from the Queue.
     * Usage:
     * <code>
     * $queue = new Queue(70);
     * $queue->Push('A puppy');
     * $item = $queue->Pull();
     * </code>
     * @return string $item An item to remove from the container.
     */
    public function Pull()
    {
        $item = null;
        if ($this->index < $this->count) {
            $item = $this->array[$this->index];
            $this->array[$this->index] = null;
            $this->index += 1;
        }
        return $item;
    }

    /**
     * Used to check if the queue has items.
     * Usage:
     * <code>
     * $queue = new Queue(70);
     * $queue->Push('A puppy');
     * $test = $queue->HasItems();
     * </code>
     * @return bool True if still has items.
     */
    public function HasItems()
    {
        return $this->index < $this->count;
    }
}
