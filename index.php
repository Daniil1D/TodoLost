<?php
require_once 'DatabaseConnection.php';
require_once 'TodoList.php';

$Db = new DatabaseConnection('localhost', 'root', '', 'Todo list');
$link = new TodoList($Db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addTodo'])) {
        $todo = $_POST['todo'];
        $link->addTodoItem($todo);
        header('Location: index.php');
        exit;
    }
}

if (isset($_GET['done'])) {
    $completeTodoId = $_GET['done'];
    $link->updateTodoStatusToDone($completeTodoId);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_GET['active'])) {
    $undoneTodoId = $_GET['active'];
    $link->updateTodoStatusToActive($undoneTodoId);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$result = $link->findAll();

$highlightedTodos = array();
foreach ($result as $row) {
    if ($row['Statusname'] === 'Done') {
        $highlightedTodos[] = $row['id'];
    }
}

include 'template.php';
?>