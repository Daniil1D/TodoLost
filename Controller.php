<?php
class Controller
{
    private $model;
    private $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }

    public function handleRequest()
    {
         // Обработка GET-параметров
        $tab = isset($_GET['tab']) ? $_GET['tab'] : '';

         // Определение SQL-запроса на основе значения параметра "tab
        if ($tab === 'active') {
            $selectQuery = "SELECT * FROM `Todo List` WHERE `Statusname` = 'Active'";
        } elseif ($tab === 'done') {
            $selectQuery = "SELECT * FROM `Todo List` WHERE `Statusname` = 'Done'";
        } else {
            $selectQuery = "SELECT * FROM `Todo List`";
        }

       // Получение соединения с базой данных и выполнение запроса
        $db = $this->model->getDb();
        $result = $db->executeQuery($selectQuery);

        // Обработка POST-запросов
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['addTodo'])) {
                $todo = $_POST['todo'];
                $this->model->addTodoItem($todo);
                header('Location: index.php');
                exit;
            }
        }

         // Обработка GET-запросов для обновления статуса задачи
        if (isset($_GET['done'])) {
            $completeTodoId = $_GET['done'];
            $this->model->updateTodoStatusToDone($completeTodoId);
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }

        if (isset($_GET['active'])) {
            $undoneTodoId = $_GET['active'];
            $this->model->updateTodoStatusToActive($undoneTodoId);
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }

        if (isset($_GET['delete'])) {
            $deleteTodoId = $_GET['delete'];
            $this->model->deleteTodoItem($deleteTodoId);
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }

        // Получение всех задач и выделение выполненных задач
        $todos = $this->model->findAll();
        $highlightedTodos = array();
        foreach ($todos as $row) {
            if ($row['Statusname'] === 'Done') {
                $highlightedTodos[] = $row['id'];
            }
        }

        // Рендеринг представления с передачей данных
        $this->view->render($result, $highlightedTodos, $this->model->getDb());
    }
}