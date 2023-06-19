<?php
class Controller
{
    private $todoList;

    public function __construct($Db)
    {
        require_once 'TodoList.php';
        $this->todoList = new TodoList($Db);
    }

    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['addTodo'])) {
                $todo = $_POST['todo'];
                $this->todoList->addTodoItem($todo);
                header('Location: index.php');
                exit;
            }
        }

        if (isset($_GET['done'])) {
            $completeTodoId = $_GET['done'];
            $this->todoList->updateTodoStatusToDone($completeTodoId);
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }

        if (isset($_GET['active'])) {
            $undoneTodoId = $_GET['active'];
            $this->todoList->updateTodoStatusToActive($undoneTodoId);
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }
}