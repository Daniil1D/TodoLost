<?php
require_once 'DatabaseConnection.php';
require_once 'TodoList.php';
require_once 'Controller.php';
require_once 'View.php';


$Db = new DatabaseConnection('localhost', 'root', '', 'Todo list');
$model = new TodoList($Db);
$view = new View();
$controller = new Controller($model, $view);

$controller->handleRequest();
?>