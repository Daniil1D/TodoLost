<?php
interface ViewInterface
{
    public function render($result, $highlightedTodos, $activeTodoCount);
}

class View implements ViewInterface
{
    private $registrationCompleted = false;

    public function render($result, $highlightedTodos, $activeTodoCount)
    {
        if ($this->registrationCompleted) {
            include 'template.php';
        } else {
            include 'RegistrationTemplate.php';
        }
    }
}
