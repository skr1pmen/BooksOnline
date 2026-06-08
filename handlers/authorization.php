<?php
require "../config/db.php";

session_start();

$email = trim($_POST['email']);
$password = trim($_POST['password']);

$error = [];

if (empty($email)) {
    $error[] = "Email обязательное поле!";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error[] = "Неверный формат email";
}
if (empty($password)) {
    $error[] = "Пароль обязательное поле!";
}

if (empty($error)) {
    $query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $query->execute([":email" => $email]);
    $user = $query->fetch();
    if (!empty($user)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: ../pages/index.php');
            exit;
        } else {
            $error[] = 'Неверный пароль';
        }
    } else {
        $error[] = 'Пользователь не найден';
    }
}

if (!empty($error)) {
    $_SESSION['error'] = $error;
    header('Location: ../pages/login.php');
    exit;
}