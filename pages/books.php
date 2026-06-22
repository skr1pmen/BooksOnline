<?php
require "../config/db.php";
session_start();

$bookId = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM books WHERE id = :id");
$query->execute([':id' => $bookId]);
$book = $query->fetch();
$query = $pdo->prepare("SELECT * FROM authors WHERE id = :author_id");
$query->execute([':author_id' => $book['author_id']]);
$author = $query->fetch();

$query = $pdo->prepare("SELECT id FROM ranted WHERE book_id = :book_id AND user_id = :user_id");
$query->execute([':book_id' => $bookId, ':user_id' => $_SESSION['user_id']]);
$isRented = $query->fetch();

ob_start();
?>

<div class="wrapper">
    <div class="book_page">
        <img src="../public/books/<?= $book['cover'] ?>" alt="<?= $book['title']?>">
        <div class="info">
            <h1 class="title"><?= $book['title'] ?></h1>
            <span class="data">Автор: <?= $author['full_name'] ?></span>
            <span class="data">Год выпуска: <?= $book['year'] ?></span>
            <span class="data">Описание:<br/> <?= $book['description'] ?></span>
            <?php if ($_SESSION['user_id'] && empty($isRented)) { ?>
                <a href="../handlers/books/rented.php?id=<?= $bookId ?>" class="btn">Арендовать</a>
            <?php } ?>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean();
require "../templates/header.php";
echo $content;
require "../templates/footer.php";
?>
