<?php 
class TodoList extends DatabaseConnection//для получения доступа к методам работы с базой данных
{
    // метод используется для добавления новой задачи в список дел.
    public function addTodoItem($todo)
    {
        $todo = mysqli_real_escape_string($this->link, $todo);

        //SQL-запрос для вставки записи
        $insertQuery = "INSERT INTO `Todo List` (`id`,`text`, `Statusname`, `active_from`, `active_to`) VALUES (NULL,'$todo','Active','','')";
        $this->executeQuery($insertQuery);
    }

    private $Db;
    public function __construct($Db)
    {
       $this->Db = $Db; 
    }
    //метод используется для обновления статуса задачи на "Done"
    public function updateTodoStatusToDone($id)
    {
        //SQL-запрос для обновления статуса задачи на "Done"
        $query = "UPDATE `Todo List` SET `Statusname` = 'Done' WHERE `id` = $id";
        $this->Db->executeQuery($query);
    }

    //метод используется для обновления статуса задачи на "Active"
    public function updateTodoStatusToActive($id)
    {

        //SQL-запрос для обновления статуса задачи на "Active"
        $query = "UPDATE `Todo List` SET `Statusname` = 'Active' WHERE `id` = $id";
        $this->Db->executeQuery($query);                 
    }

}