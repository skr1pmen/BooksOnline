<?php
require "../../config/db.php";
session_start();

$title = $_POST['title'];
$desc = $_POST['description'];
$author = $_POST['authorId'];
$year = $_POST['year'];
$id = $_POST['id'];
$cover = $_FILES['cover'];

$error = [];

if (empty($title)) {
    $error = "Необходимо указать название книги";
}
if (empty($desc)) {
    $error = "Необходимо указать описание книги";
}
if (empty($author)) {
    $error = "Необходимо указать автора книги";
}
if (empty($year)) {
    $error = "Необходимо указать год выпуска книги";
}

function execute($pdo, $sql, $params = []) {
    $query = $pdo->prepare($sql);
    $query->execute($params);
    return $query->fetch();
}

if (empty($error)) {
    $query = $pdo->prepare("SELECT id FROM authors WHERE full_name = :name");
    $query->execute([':name' => $author]);
    $authorId = $query->fetch();

    $query = $pdo->prepare("SELECT * FROM books WHERE id = :id");
    $query->execute([':id' => $id]);
    $book = $query->fetch();

    $newAuthorId = [];
    $newAuthorId['id'] = $book['author_id'];

    if (empty($authorId)) {
        # Создание нового автора
        $newAuthorId = execute(
            $pdo,
            "INSERT INTO authors (full_name) VALUES (:name) RETURNING id",
            [':name' => $author]
        );
    } else {
        if ($authorId['id'] !== $book['author_id']) {
            # Меняем автора
            $newAuthorId = $authorId;
        }
    }

    if (!empty($cover)) {
        try {
            move_uploaded_file($cover['tmp_name'], '../../public/books/'. $title . $year . '.jpg');
        } catch (Exception $e) {
            $error[] = "Не удалось загрузить обложку";
        }
    }

    if ($title != $book['title'] || $year != $book['year']) {
        $path = "../../public/books/";
        rename($path.$book['title'].$book['year'].'.jpg', $path.$title.$year.'.jpg');
    }

    execute(
        $pdo,
        "UPDATE books 
            SET title = :title, description = :description, 
                year = :year, author_id = :author_id, cover = :cover",
        [
            ":title" => $title,
            ":description" => $desc,
            ":year" => $year,
            ':author_id' => $newAuthorId['id'],
            ":cover" => $title.$year.'.jpg'
        ]
    );
    header("location: ../../pages/editbook.php?id=".$id);
    exit;
}

if (!empty($error)) {
    $_SESSION["error"] = $error;
    header("location: ../../pages/editbook.php?id=".$id);
    exit;
}

