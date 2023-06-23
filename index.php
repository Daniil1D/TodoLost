<?php
require_once 'Model/DatabaseConnection.php';
require_once 'Model/TodoList.php';
require_once 'Controller/Controller.php';
require_once 'View/View.php';
require_once 'Controller/RegistrationController.php';

$Db = new DatabaseConnection('localhost', 'root', '', 'Todo list');
$model = new TodoList($Db);
$view = new View();
$controller = new Controller($model, $view, $Db);
$registrationController = new RegistrationController($model, $view, $Db);

// Определите, какой контроллер использовать на основе GET-параметров или других условий
if (isset($_GET['registration'])) {
    $registrationController->handleRequest();
} else {
    $controller->handleRequest();
}