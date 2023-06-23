<?php

class RegistrationView implements ViewInterface
{
    private $registrationCompleted = false;

    public function render($result, $highlightedTodos, $activeTodoCount)
    {
        if ($this->registrationCompleted) {
            include 'RegistrationTemplate.php';
        } else {
            include 'Controller.php';
        }
       
    }

    public function setRegistrationCompleted($completed)
    {
        $this->registrationCompleted = $completed;
    }
}