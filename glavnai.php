<?php
$link = mysqli_connect('localhost', 'root', '', 'Todo List');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($_POST['addTodo'])) {
    $todo = $_POST['todo'];

    // SQL-запрос для вставки записи
    $insertQuery = "INSERT INTO `Todo List` (`id`,`text`, `Statusname`, `active_from`, `active_to`) VALUES (NULL,'$todo','','','')";
    mysqli_query($link, $insertQuery);

     // Перенаправление на текущую страницу для обновления.
     header('Location: ' . $_SERVER['PHP_SELF']);
     exit;
  }
}

// Обновление результатов запроса после добавления записи
$selectQuery = "SELECT * FROM `Todo List`";
$result = mysqli_query($link, $selectQuery);
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
          <button type="button" class="btn btn-info">All</button>
          <button type="button" class="btn btn-outline-secondary">Active</button>
          <button type="button" class="btn btn-outline-secondary">Done</button>
        </div>
      </div>

      <table class="table">
        <tbody>
          <?php
          while ($row = mysqli_fetch_assoc($result)) {
            $text = $row['text'];
            echo "<tr>";
            echo "<td>$text</td>";
            echo '<td>
                    <button type="button" class="btn btn-outline-success btn-sm float-right">
                      <i class="fa fa-exclamation"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm float-right">
                      <i class="fa fa-trash-o"></i>
                    </button>
                  </td>';
            echo "</tr>";
          }
          ?>
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