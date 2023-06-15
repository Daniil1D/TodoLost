<?php
$link = mysqli_connect('localhost', 'root', '', 'Todo List');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($_POST['addTodo'])) {
    $todo = $_POST['todo'];

    // SQL-запрос для вставки записи
    $insertQuery = "INSERT INTO `Todo List` (`id`,`text`, `Statusname`, `active_from`, `active_to`) VALUES (NULL,'$todo','Active','','')";
    mysqli_query($link, $insertQuery);

    // Перенаправление на текущую страницу для обновления.
    header('Location: index.php');
    exit;
  }
}

// Обработка выделения записей
$highlightedTodos = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['highlight'])) {
  $highlightedTodos = $_GET['highlight'];

  if (!is_array($highlightedTodos)) {
    $highlightedTodos = [$highlightedTodos];
  }
}

// Обработка GET-запроса на изменение статуса "Done"
if (isset($_GET['done'])) {
  $completeTodoId = $_GET['done'];

  // Подготовка и выполнение запроса на обновление записи в базе данных
  $query = "UPDATE `Todo List` SET `Statusname` = 'Done' WHERE `id` = $completeTodoId";

  mysqli_query($link, $query);

  // Перенаправление на текущую страницу для обновления
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}

// Обработка GET-запроса на изменение статуса "Active"
if (isset($_GET['Active'])) {
  $undoneTodoId = $_GET['Active'];

  // Подготовка и выполнение запроса на обновление записи в базе данных
  $query = "UPDATE `Todo List` SET `Statusname` = 'Active' WHERE `id` = $undoneTodoId";
  mysqli_query($link, $query);

  // Перенаправление на текущую страницу для обновления
  header('Location: ' . $_SERVER['PHP_SELF']);
  exit;
}


// Обновление результатов запроса после добавления записи
$selectQuery = "SELECT * FROM `Todo List`";
$result = mysqli_query($link, $selectQuery);


// Получение выделенных записей с статусом "Done"
$highlightedTodos = array();
while ($row = mysqli_fetch_assoc($result)) {
  if ($row['Statusname'] === 'Done') {
    $highlightedTodos[] = $row['id'];
  }
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <title>Todo App</title>
</head>

<body>
  <div id="root" role="main" class="container">
    <div class="todo-app">
      <div class="app-header d-flex">
        <h1>Todo List</h1>
        <h2>1 more to do, 3 done</h2>
      </div>
      <div class="top-panel d-flex">
        <input type="text" class="form-control search-input" placeholder="type to search" />
        <div class="btn-group">
          <a href="#" class="btn btn-info">All</a>
          <a href="#" class="btn btn-outline-secondary">Active</a>
          <a href="#" class="btn btn-outline-secondary">Done</a>
        </div>
      </div>

      <table class="table">
        <tbody>
          <?php if (isset($_GET['tab'])) {
            $tab = $_GET['tab'];
            if ($tab === 'Active') {
              $selectQuery = "SELECT * FROM `Todo List` WHERE `Statusname` = 'Active'";
            } elseif ($tab === 'done') {
              $selectQuery = "SELECT * FROM `Todo List` WHERE `Statusname` = 'Done'";
            } else {
              $selectQuery = "SELECT * FROM `Todo List`"; //Если параметр tab не существует в GET-запросе, то выбирает все записи из таблицы "Todo List" без фильтрации по статусу.
            }
          } else {
            $selectQuery = "SELECT * FROM `Todo List`";
          }
          $result = mysqli_query($link, $selectQuery);

          while ($row = mysqli_fetch_assoc($result)) :
            $id = $row['id'];
            $text = $row['text'];
            $Statusname = $row['Statusname'];
          ?>
            <tr>
              <td>
                <?php if (is_array($highlightedTodos) && in_array($id, $highlightedTodos)) : ?>
                  <span class="todo-list-item-label" style="color: steelblue; font-weight: bold">
                  <?php else : ?>
                    <span class="todo-list-item-label">
                    <?php endif; ?>
                    <?php echo $text; ?>
                    </span>
                    <?php if ($Statusname === 'Done') : ?>
                      <a href="?Active=<?php echo $id; ?>" class="btn btn-outline-success btn-sm float-right">
                        <i class="fa fa-exclamation"></i>
                      </a>
                    <?php else : ?>
                      <a href="?done=<?php echo $id; ?>" class="btn btn-outline-secondary btn-sm float-right">
                        <i class="fa fa-exclamation"></i>
                      </a>
                    <?php endif; ?>
                    <a href="?delete=<?php echo $id; ?>" class="btn btn-outline-danger btn-sm float-right mr-2"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <form class="bottom-panel d-flex" method="POST">
        <input type="text" class="form-control new-todo-label" placeholder="What needs to be done?" name="todo" required>
        <button type="submit" class="btn btn-outline-secondary" name="addTodo">Add</button>
      </form>
    </div>
  </div>
</body>

</html>