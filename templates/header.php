<?php
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/style.css">
    <title><?= $page_title ?? 'Онлайн библиотека' ?></title>
</head>
<body>
    <header>
        <div class="container">
            <a href="/" class="logo">📚 Онлайн библиотека</a>
            <nav class="nav_link">
                <ul class="nav_items">
                    <li class="item"><a class="link" href="/">🏠 Главная</a></li>
                    <li class="item"><a class="link" href="../pages/authors.php">🧔 Авторы</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="item"><a class="link" href="../pages/profile.php">🙍‍♀️ Профиль</a></li>
                        <li class="item"><a class="link" href="../pages/logout.php">🚪 Выход</a></li>
                    <?php  else: ?>
                        <li class="item"><a class="link btn" href="../pages/login.php">🔑 Вход</a></li>
                        <li class="item"><a class="link btn" href="../pages/register.php">📝 Регистрация</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">