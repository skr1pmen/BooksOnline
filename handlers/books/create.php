<?php
require "../../config/db.php";

session_start();


$title = trim($_POST['title']); # Сказка о царе Солтане
$description = trim($_POST['description']); # Сказка, а не книга
$year = trim($_POST['year']); # 1999
$authorId = trim($_POST['authorId']); # Пушкин Александр Сергеевич
$cover = $_FILES['cover'];

$error = [];

if (empty($title)) {
    $error[] = "'Название книги' обязательный параметр!";
}
if (empty($description)) {
    $error[] = "'Описание' обязательный параметр!";
}
if (empty($year)) {
    $error[] = "'Год выпуска' обязательный параметр!";
}
if (empty($authorId)) {
    $error[] = "'Автор' обязательный параметр!";
}

//move_uploaded_file();

function createBook($title, $desc, $year, $authorId, $file, $pdo) {
    $fileName = $title . $year . ".jpg";
    $path = "../../public/books/";

    try {
        move_uploaded_file($file['tmp_name'], $path.$fileName);
    } catch (Exception $err) {
        return false;
    }

    $query = $pdo->prepare("INSERT INTO books (title, description, year, author_id, cover)
            VALUES (:title, :description, :year, :author_id, :cover) RETURNING id");
    $query->execute([
        ':title' => $title,
        ':description' => $desc,
        ':year' => $year,
        ':author_id' => $authorId,
        ':cover' => $fileName
    ]);
    return $query->fetch();
}

if (empty($error)) {
    $query = $pdo->prepare("SELECT id FROM authors WHERE full_name = :full_name");
    $query->execute([':full_name' => $authorId]);
    $author = $query->fetch();
    if ($author) {
        $query = $pdo->prepare("SELECT id FROM books WHERE title = :title AND year = :year");
        $query->execute([':title' => $title, ':year' => $year]);
        $book = $query->fetch();
        if ($book) {
            $error[] = "Подобная книга уже есть!";
        } else {
            $isOk = createBook($title, $description, $year, $author['id'], $cover, $pdo);
            if ($isOk) {
                header("Location: ../../pages/index.php");
                exit;
            } else {
                $error[] = "Ошибка сервера!";
                header("Location: ../../pages/createBook.php");
                exit;
            }
        }
    } else {
        $query = $pdo->prepare("INSERT INTO authors (full_name) VALUES (:full_name) RETURNING id");
        $query->execute([':full_name' => $authorId]);
        $author = $query->fetch();

        $isOk = createBook($title, $description, $year, $author['id'], $cover, $pdo);
        if ($isOk) {
            header("Location: ../../pages/index.php");
            exit;
        } else {
            $error[] = "Ошибка сервера!";
            header("Location: ../../pages/createBook.php");
            exit;
        }
    }

//    $query = $pdo->prepare(
//        "SELECT id FROM books
//          WHERE title = :title AND year = :year AND author_id = :author_id"
//    );
//    $query->execute([
//        ':title' => $title,
//        ':year' => $year,
//        ':author_id' => $authorId
//    ]);
//    $existBook = $query->fetch();
//    if ($existBook) {
//        $query = $pdo->prepare("SELECT id FROM authors WHERE id = :id");
//        $query->execute([
//            ':id' => $authorId
//        ]);
//        $existAuthor = $query->fetch();
//        if (!$existAuthor) {
//
//        }
//    }
}

if (!empty($error)) {
    $_SESSION["error"] = $error;
    header("Location: ../../pages/createBook.php");
    exit;
}