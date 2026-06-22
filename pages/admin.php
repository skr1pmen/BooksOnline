<?php
$page_title = "Главная";
ob_start();
session_start();

require "../config/db.php";

$query = $pdo->prepare("SELECT * FROM books ORDER BY id desc");
$query->execute();
$books = $query->fetchAll();
$booksFinally = [];
foreach ($books as $book) {
    $query = $pdo->prepare("SELECT full_name FROM authors WHERE id = :id");
    $query->execute([':id' => $book['author_id']]);
    $author = $query->fetch();
    $booksFinally[] = [
        'id' => $book['id'],
        'author' => $author['full_name'],
        'title' => $book['title'],
        'description' => $book['description'],
        'year' => $book['year'],
        'cover' => $book['cover'],
    ];
}
?>

    <div class="wrapper">
        <div class="books">
            <?php foreach ($booksFinally as $book) { ?>
                <div class="book">
                    <img src="../public/books/<?= $book['cover'] ?>" alt="Обложка книги" class="cover">
                    <h2 class="book_title"><?= $book['title'] ?></h2>
                    <span class="book_author"><?= $book['author'] ?></span>
                    <a href="./books.php?id=<?= $book['id'] ?>" class="btn">Подробнее</a>
                    <a href="./editbook.php?id=<?= $book['id'] ?>" class="btn">Редактировать</a>
                    <a href="../handlers/books/deletebook.php?id=<?= $book['id'] ?>" class="btn">Удалить</a>
                </div>
            <?php } ?>
        </div>
    </div>

<?php
$content = ob_get_clean();
require_once "../templates/header.php";
echo $content;
require_once "../templates/footer.php";
?>