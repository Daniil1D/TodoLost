<?php

class DatabaseConnection
{
    protected $link;

    public function __construct($host, $username, $password, $database)
    {
        $this->link = mysqli_connect($host, $username, $password, $database);
    }
    public function getLink()
    {
        return $this->link;
    }

    public function executeQuery($query)
    {
        return mysqli_query($this->link, $query);
    }

    public function getLastInsertedId()
    {
        return mysqli_insert_id($this->link);
    }

    public function closeConnection()
    {
        mysqli_close($this->link);
    }
}
