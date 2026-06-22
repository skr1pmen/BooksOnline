<?php
require '../../config/db.php';
session_start();

$bookId = $_GET['id'];
$userId = $_SESSION['user_id'];

$query = $pdo->prepare(
    "DELETE FROM ranted WHERE book_id = :book_id AND user_id = :user_id"
);
$query->execute([':book_id' => $bookId, ':user_id' => $userId]);
header('Location: ../../pages/profile.php');

