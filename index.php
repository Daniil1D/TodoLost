<?php
require_once 'DatabaseConnection.php';
require_once 'TodoList.php';

$db = new DatabaseConnection('localhost', 'root', '', 'Todo List');

$link = new TodoList($db);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['addTodo'])) {
    $todo = $_POST['todo'];
    $link->addTodoItem($todo);

    // Перенаправление на текущую страницу для обновления.
    header('Location: index.php');
    exit;
  }
}

// Обработка GET-запроса на изменение статуса "Done"
if (isset($_GET['done'])) {
  $completeTodoId = $_GET['done'];
  $link->updateTodoStatusToDone($completeTodoId);

  // Перенаправление на текущую страницу для обновления
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

// Обработка GET-запроса на изменение статуса "Active"
if (isset($_GET['active'])) {
  $undoneTodoId = $_GET['active'];
  $link->updateTodoStatusToActive($undoneTodoId);

  // Перенаправление на текущую страницу для обновления
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}


// Обновление результатов запроса после добавления записи
$selectQuery = "SELECT * FROM `Todo List`";
$result = $link->executeQuery($selectQuery);


// Получение выделенных записей с статусом "Done"
$highlightedTodos = array();
while ($row = mysqli_fetch_assoc($result)) {
  if ($row['Statusname'] === 'Done') {
    $highlightedTodos[] = $row['id'];
  }
}
include 'template.php';