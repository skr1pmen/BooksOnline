<?php
require "../../config/db.php";
session_start();

$bookId = $_GET['id'];

$query = $pdo->prepare("SELECT cover FROM books WHERE id = :id");
$query->execute([":id" => $bookId]);
$cover = $query->fetch();

$query = $pdo->prepare("DELETE FROM books WHERE id = :id");
$query->execute([
    ":id" => $bookId
]);

if (is_file('../../public/books/' . $cover['cover'])) {
    try {
        unlink("../../public/books/" . $cover['cover']);
    } catch (Exception $e) {
        header("Location: ../../pages/admin.php");
        exit;
    }
}

header("Location: ../../pages/admin.php");
exit;