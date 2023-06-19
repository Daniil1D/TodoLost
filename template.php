<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Todo List</title>
    <style>
        .active-tab {
            background-color: steelblue;
            color: white;
        }
    </style>
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
                    <a href="?tab=all" class="btn btn-outline-secondary <?php echo isset($_GET['tab']) && $_GET['tab'] === 'all' ? 'active-tab' : ''; ?>" class="btn btn-info">All</a>
                    <a href="?tab=active" class="btn btn-outline-secondary <?php echo isset($_GET['tab']) && $_GET['tab'] === 'active' ? 'active-tab' : ''; ?>">Active</a>
                    <a href="?tab=done" class="btn btn-outline-secondary <?php echo isset($_GET['tab']) && $_GET['tab'] === 'done' ? 'active-tab' : ''; ?>">Done</a>
                </div>
            </div>

            <table class="table">
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td>
                                <?php if (is_array($highlightedTodos) && in_array($row['id'], $highlightedTodos)) : ?>
                                    <span class="todo-list-item-label" style="color: steelblue; font-weight: bold">
                                <?php else : ?>
                                    <span class="todo-list-item-label">
                                <?php endif; ?>
                                    <?php echo $row['text']; ?>
                                </span>
                                <?php if ($row['Statusname'] === 'Done') : ?>
                                    <a href="?active=<?php echo $row['id']; ?>" class="btn btn-outline-success btn-sm float-right">
                                        <i class="fa fa-exclamation"></i>
                                    </a>
                                <?php else : ?>
                                    <a href="?done=<?php echo $row['id']; ?>" class="btn btn-outline-secondary btn-sm float-right">
                                        <i class="fa fa-exclamation"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-outline-danger btn-sm float-right mr-2"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
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