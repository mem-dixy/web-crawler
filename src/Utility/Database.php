<?php namespace Utility;
// Class: CS 4350 SLC Fall 19 21412
// Assignment: CS 4350 Final
// Project: final-Mem-Dixy
// Student: Clifford Peters

class Database
{
    public function __construct()
    {
        $this->host = '167.99.54.84';
        $this->username = 'cliffordpeters';
        $this->password = 'letmein';
        $this->database = 'cliffordpeters';
        $this->port = '3306';
        $this->socket = '';
        $this->connection = \mysqli_connect(
            $this->host,
            $this->username,
            $this->password,
            $this->database,
            $this->port,
            $this->socket
        );
        if ($this->connection->connect_error) {
            $errno = $this->connection->connect_errno;
            $error = $this->connection->connect_error;
            die('Connect Error (' . $errno . ') ' . $error);
        }
        $this->result = null;
    }

    function __destruct()
    {
        $this->free();
        mysqli_close($this->connection);
    }

    private function free()
    {
        if ($this->result != null) {
            mysqli_free_result($this->result);
        }
    }

    public function insert($query)
    {
        \mysqli_query($this->connection, $query);
    }

    public function query($query)
    {
        $this->free();
        $this->result = \mysqli_query($this->connection, $query);
        var_dump($this->result);
        return $this->result;
    }
}
