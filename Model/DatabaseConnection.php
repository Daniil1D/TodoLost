<?php
interface DatabaseConnectionInterface
{
    public function getLink();
    public function executeQuery($query);
    public function getLastInsertedId();
    public function closeConnection();
}

class DatabaseConnection implements DatabaseConnectionInterface
{
    protected $link;

    public function __construct($host, $username, $password, $database)
    {
        $this->link = mysqli_connect($host, $username, $password, $database);
    }

    // Возвращает сохраненное соединение с базой данных.
    public function getLink()
    {
        return $this->link;
    }

    // Выполняет переданный SQL-запрос ($query) с использованием функции mysqli_query.
    // Результат выполнения запроса возвращается.
    public function executeQuery($query)
    {
        return mysqli_query($this->link, $query);
    }

    // Возвращает идентификатор последней вставленной записи в базу данных.
    public function getLastInsertedId()
    {
        return mysqli_insert_id($this->link);
    }

    // Закрывает соединение с базой данных.
    public function closeConnection()
    {
        mysqli_close($this->link);
    }
}