<?php
require_once 'DatabaseConnection.php';
require_once 'Controller.php';

$Db = new DatabaseConnection('localhost', 'root', '', 'Todo List');
$controller = new Controller($Db);

$controller->handleRequest();

include 'template.php';
?>