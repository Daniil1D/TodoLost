<?php
interface ViewInterface
{
    public function render($result, $highlightedTodos, $activeTodoCount);
}

class View implements ViewInterface
{
    public function render($result, $highlightedTodos, $activeTodoCount)
    {
        include 'template.php';
    }
}
