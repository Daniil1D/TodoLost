<?php
interface TodoListInterface
{
    public function getDb();
    public function findAll();
    public function addTodoItem($todo);
    public function updateTodoStatus($id, $status);
    public function deleteTodoItem($id);
    public function getSelectQuery($tab);
    public function handleAddTodo();
    public function handleTodoStatusUpdate();
    public function handleTodoDeletion();
    public function getActiveTodoCount();
    public function getHighlightedTodos($todos);
    public function isActiveTab($tabName);
    public function countActiveTodos($Db);
}

class TodoList implements TodoListInterface
{
    private $Db;

    public function __construct($Db)
    {
        $this->Db = $Db;
    }

    public function getDb()
    {
        return $this->Db;
    }

    public function findAll()
    {
        $selectQuery = "SELECT * FROM `Todo List`";
        $result = $this->Db->executeQuery($selectQuery);
        $todos = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $todos[] = $row;
        }
        return $todos;
    }

    // Метод используется для добавления новой задачи в список дел.
    public function addTodoItem($todo)
    {
        $todo = mysqli_real_escape_string($this->Db->getLink(), $todo);

        // SQL-запрос для вставки записи
        $insertQuery = "INSERT INTO `Todo List` (`id`, `text`, `Statusname`, `active_from`, `active_to`) VALUES (NULL, '$todo', 'Active', '', '')";
        $this->Db->executeQuery($insertQuery);
    }

    // Метод используется для обновления статуса задачи на "Done" или "Active".
    public function updateTodoStatus($id, $status)
    {
        $status = mysqli_real_escape_string($this->Db->getLink(), $status);

        // SQL-запрос для обновления статуса задачи
        $query = "UPDATE `Todo List` SET `Statusname` = '$status' WHERE `id` = $id";
        $this->Db->executeQuery($query);
    }

    public function deleteTodoItem($id)
    {
        // SQL-запрос для удаления задачи
        $query = "DELETE FROM `Todo List` WHERE `id` = $id";
        $this->Db->executeQuery($query);
    }

    // Метод для определения SQL-запроса на основе значения параметра "tab"
    public function getSelectQuery($tab)
    {
        if ($tab === 'active') {
            return "SELECT * FROM `Todo List` WHERE `Statusname` = 'Active'";
        } elseif ($tab === 'done') {
            return "SELECT * FROM `Todo List` WHERE `Statusname` = 'Done'";
        } else {
            return "SELECT * FROM `Todo List`";
        }
    }

    // Метод для обработки POST-запроса на добавление новой задачи
    public function handleAddTodo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['addTodo'])) {
                $todo = $_POST['todo'];
                $this->addTodoItem($todo);
                header('Location: template.php');
                exit;
            }
        }
    }

    // Метод для обработки GET-запроса на обновление статуса задачи или удаление задачи
    public function handleTodoStatusUpdate()
    {
        if (isset($_GET['done'])) {
            $todoId = $_GET['done'];
            $this->updateTodoStatus($todoId, 'Done');
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }

        if (isset($_GET['active'])) {
            $todoId = $_GET['active'];
            $this->updateTodoStatus($todoId, 'Active');
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    public function handleTodoDeletion()
    {
        if (isset($_GET['delete'])) {
            $todoId = $_GET['delete'];
            $this->deleteTodoItem($todoId);
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    // Метод для получения количества активных задач
    public function getActiveTodoCount()
    {
        $selectActiveQuery = "SELECT COUNT(*) AS count FROM `Todo List` WHERE `Statusname` = 'Active'";
        $resultActive = $this->Db->executeQuery($selectActiveQuery);
        $rowActive = mysqli_fetch_assoc($resultActive);
        $countActive = $rowActive['count'];
        return $countActive;
    }

    // Метод для выделения выполненных задач
    public function getHighlightedTodos($todos)
    {
        $highlightedTodos = array();
        foreach ($todos as $row) {
            if ($row['Statusname'] === 'Done') {
                $highlightedTodos[] = $row['id'];
            }
        }
        return $highlightedTodos;
    }

    public function isActiveTab($tabName)
    {
        if (isset($_GET['tab']) && $_GET['tab'] === $tabName) {
            return 'active-tab';
        }
        return '';
    }

    public function countActiveTodos($Db)
    {
        $selectActiveQuery = "SELECT COUNT(*) AS count FROM `Todo List` WHERE `Statusname` = 'Active'";
        $resultActive = $Db->executeQuery($selectActiveQuery);
        $rowActive = mysqli_fetch_assoc($resultActive);
        return $rowActive['count'];
    }

    public function addUser($login, $password)
    {
        // Проверяем, существует ли пользователь с таким логином
        $checkQuery = "SELECT * FROM `user` WHERE `login` = '$login'";
        $checkResult = mysqli_query($this->Db->getLink(), $checkQuery);

        // Если найдены строки с указанным логином, значит пользователь уже существует
        if (mysqli_num_rows($checkResult) > 0) {

            header("Location: userr.php");
            exit;
        } else {
            $hashedPassword = md5($password); // Используем функцию md5() для хеширования пароля

            // SQL-запрос для вставки новой записи в таблицу user
            $query = "INSERT INTO `user` (`id`, `login`, `password`) VALUES (NULL, '$login', '$hashedPassword');";
            mysqli_query($this->Db->getLink(), $query);

            header("Location: index.php"); 
            exit;
        }
    }
}
