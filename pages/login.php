<?php
$page_title = "Вход";
session_start();
?>
<head>
    <link rel="stylesheet" href="../css/style.css">
    <title><?= $page_title ?? "Онлайн библиотека" ?></title>
</head>
<div class="wrapper_">
    <a href="../pages/index.php" class="back">Назад</a>
    <form action="../handlers/authorization.php" method="post" class="reg_form">
        <h2 class="title">Авторизация</h2>
        <label>
            <span class="placeholder">Введите вашу почту</span>
            <input type="email" name="email">
        </label>
        <label>
            <span class="placeholder">Введите пароль</span>
            <input type="password" name="password">
        </label>
        <label class="remember"><input type="checkbox" name="rememberMe">Запомнить меня</label>
        <input type="submit" value="Войти">
        <?= $_SESSION['error'] ?? "" ?>
    </form>
</div>