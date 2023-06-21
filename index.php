<?php
require_once 'Model/DatabaseConnection.php';
require_once 'Model/TodoList.php';
require_once 'Controller/Controller.php';
require_once 'View/View.php';


$Db = new DatabaseConnection('localhost', 'root', '', 'Todo list');
$model = new TodoList($Db);
$view = new View();
$controller = new Controller($model, $view, $Db);

$controller->handleRequest();
?>