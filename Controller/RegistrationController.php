<?php
require_once 'View/RegistrationView.php'; 

class RegistrationController implements ControllerInterface
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';

            if (!empty($login) && !empty($password)) {
                $this->model->addUser($login, $password);
            } else {
                $error = 'Вы не ввели логин или пароль';
                $this->view->render(['error' => $error]);
                return;
            }
        }
    }
}