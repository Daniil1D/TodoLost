<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h2>Регистрация</h2>
    <?php
    if (isset($error)) {
        echo '<p>' . $error . '</p>';
    }
    ?>
    <form method="POST">
        <p>Логин:<input type="text" name="login"></p>
        <p>Пароль:<input type="password" name="password"></p>
        <p><input type="submit" name="go" value="Зарегистрироваться"></p>
    </form>
    <form method="GET" action="template.php">
        <p><input type="submit" value="Авторизоваться"></p>
    </form>
</body>

</html>