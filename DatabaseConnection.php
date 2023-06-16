<?php 
class DatabaseConnection{
    protected $link;

    public function __construct($host, $username, $password, $database)//Конструктор класса, который устанавливает соединение с базой данных MySQL
    {
        $this->link = mysqli_connect($host, $username, $password, $database);
    }

    //Метод выполняет SQL-запрос к базе данных.
   public function executeQuery($query)
   {
    return mysqli_query($this->link, $query);
   }

   //Метод для получения последнего вставленного идентификатора (ID)
   public function getLastInsertedId()
   {
    return mysqli_insert_id($this->link);
   }

   //Метод для закрытия соединения с базой данных
   public function closeConnection()
   {
    mysqli_close($this->link);
   }
}
