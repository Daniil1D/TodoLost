<html>
<head>
    <link rel="stylesheet" href="styleavtorizacia.css">
    <title>Авторизация</title>
</head>
<body>
    <h2>Авторизация</h2>
    <?php
    if(isset($error)) {
        echo '<p>' . $error . '</p>';
    }
    ?>
    <form method="POST">
        <p>Логин:<input type="text" name="login"></p>
        <p>Пароль:<input type="password" name="password"></p>
        <p><input type="submit" value="Войти"></p>
    </form>
</body>
</html>