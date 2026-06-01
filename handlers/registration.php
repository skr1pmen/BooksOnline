<?php
require "../config/db.php";

session_start();

$fullName = trim($_POST['full_name']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$repeatPassword = trim($_POST['repeat_password']);

$error = [];

if (empty($fullName)) {
    $error[] = "ФИО обязательное поле!";
}
if (empty($email)) {
    $error[] = "Email обязательное поле!";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error[] = "Неверный формат email";
}
if (empty($password)) {
    $error[] = "Пароль обязательное поле!";
}
if (empty($repeatPassword)) {
    $error[] = "Повторённый пароль обязательное поле!";
}
if ($repeatPassword != $password) {
    $error[] = "Пароли должны совпадать!";
}

if (empty($error)) {
    $user_id = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $user_id->execute([':email' => $email]);
    if ($user_id->fetchAll()) {
        $error[] = "Пользователь с такой почтой уже существует!";
    } else {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = $pdo->prepare(
            "INSERT INTO users (full_name, email, password) 
                    VALUES (:full_name, :email, :password) RETURNING id"
        );
        $query->execute([
            ':full_name' => $fullName,
            ':email' => $email,
            ':password' => $hashPassword
        ]);
        $user_id = $query->fetchAll();
        $_SESSION['user_id'] = $user_id[0]['id'];
        header('Location: ../pages/index.php');
        exit;
    }
}
if (!empty($error)) {
    $_SESSION['error'] = $error;
    header('Location: ../pages/register.php');
    exit;
}