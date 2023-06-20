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

        // Получение соединения с базой данных
        $db = $this->model->getDb();

        // Получение SQL-запроса на основе значения параметра "tab"
        $selectQuery = $this->model->getSelectQuery($tab);

        // Выполнение запроса
        $result = $db->executeQuery($selectQuery);

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

        // Запрос для получения активных записей
        $countActive = $this->model->getActiveTodoCount();

        // Получение всех задач и выделение выполненных задач
        $todos = $this->model->findAll();
        $highlightedTodos = $this->model->getHighlightedTodos($todos);

        // Рендеринг представления с передачей данных
        $this->view->render($result, $highlightedTodos, $db);
    }
}
