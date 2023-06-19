<?php

class DatabaseConnection
{
    protected $link;

    public function __construct($host, $username, $password, $database)
    {
        $this->link = mysqli_connect($host, $username, $password, $database);
    }
    //возвращает сохраненное соединение с базой данных.
    public function getLink()
    {
        return $this->link;
    }
    //выполняет переданный SQL-запрос ($query) с использованием функции mysqli_query. Результат выполнения запроса возвращается.
    public function executeQuery($query)
    {
        return mysqli_query($this->link, $query);
    }
    //возвращает идентификатор последней вставленной записи в базу данных
    public function getLastInsertedId()
    {
        return mysqli_insert_id($this->link);
    }
    //закрывает соединение с базой данных 
    public function closeConnection()
    {
        mysqli_close($this->link);
    }
}
