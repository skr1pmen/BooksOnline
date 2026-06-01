<?php
$page_title = "Регистрация";
session_start();
?>
<head>
    <link rel="stylesheet" href="../css/style.css">
    <title><?= $page_title ?? "Онлайн библиотека" ?></title>
</head>
<div class="wrapper">
    <a href="../pages/index.php" class="back">Назад</a>
    <form action="../handlers/registration.php" method="post" class="reg_form">
        <h2 class="title">Регистрация</h2>
        <label>
            <span class="placeholder">Введите ФИО</span>
            <input type="text" name="full_name">
        </label>
        <label>
            <span class="placeholder">Введите вашу почту</span>
            <input type="email" name="email">
        </label>
        <label>
            <span class="placeholder">Введите пароль</span>
            <input type="password" name="password">
        </label>
        <label>
            <span class="placeholder">Повторите ваш пароль</span>
            <input type="password" name="repeat_password">
        </label>
        <label class="remember"><input type="checkbox" name="rememberMe">Запомнить меня</label>
        <input type="submit" value="Зарегистрироваться">
        <?= $_SESSION['error'] ?? "" ?>
    </form>
</div>