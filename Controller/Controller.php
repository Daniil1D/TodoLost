<?php
interface ControllerInterface
{
    public function handleRequest();
}

class Controller implements ControllerInterface
{
    private $model;
    private $view;
    private $Db;

    public function __construct($model, $view, $Db)
    {
        $this->model = $model;
        $this->view = $view;
        $this->Db = $Db;
    }

    public function handleRequest()
    {
        // Обработка GET-параметров
        $tab = isset($_GET['tab']) ? $_GET['tab'] : '';

        // Получение соединения с базой данных
        $Db = $this->model->getDb();

        // Запрос для получения активных записей
        $activeTodoCount = $this->model->countActiveTodos($Db);

        // Получение SQL-запроса на основе значения параметра "tab"
        $selectQuery = $this->model->getSelectQuery($tab);

        // Выполнение запроса
        $result = $Db->executeQuery($selectQuery);

        // Обработка POST-запросов
        $this->model->handleAddTodo();

        // Обработка GET-запросов для обновления статуса задачи
        if (isset($_GET['done'])) {
            $this->model->handleTodoStatusUpdate('done');
        }

        if (isset($_GET['active'])) {
            $this->model->handleTodoStatusUpdate('active');
        }

        if (isset($_GET['delete'])) {
            $this->model->handleTodoDeletion();
        }

        // Получение всех задач и выделение выполненных задач
        $todos = $this->model->findAll();
        $highlightedTodos = $this->model->getHighlightedTodos($todos);

        // Рендеринг представления с передачей данных
        $this->view->render($result, $highlightedTodos, $activeTodoCount);

        $isActiveTab = $this->model->isActiveTab($tab);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';

            if (!empty($login) && !empty($password)) {
                $this->model->addUser($login, $password);
                return;
            } else {
                $error = 'Вы не ввели логин или пароль';
                $this->view->render(['error' => $error]);
                return;
            }
        }
    }
}
