<?php
$host = 'localhost';
$dbname = 'booksonline';
$username = 'postgres';
$password = '';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $error) {
    die("Ошибка подключения к базе данных: " . $error->getMessage());
}

session_start();