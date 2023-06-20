<?php
class View
{
    public function render($result, $highlightedTodos, $db)
    {
        include 'template.php';
    }
    private function isActiveTab($tabName)
    {
        if (isset($_GET['tab']) && $_GET['tab'] === $tabName) {
            return 'active-tab';
        }
        return '';
    }

    // Возвращает количество активных задач.
    private function countActiveTodos($db)
    {
        $selectActiveQuery = "SELECT COUNT(*) AS count FROM `Todo List` WHERE `Statusname` = 'Active'";
        $resultActive = $db->executeQuery($selectActiveQuery);
        $rowActive = mysqli_fetch_assoc($resultActive);
        return $rowActive['count'];
    }
}
?>
