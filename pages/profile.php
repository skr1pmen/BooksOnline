<?php
session_start();
$page_title = "Профиль";

require "../config/db.php";
$query = $pdo->prepare(
        "SELECT * FROM users WHERE id = :id"
);
$query->execute([':id' => $_SESSION['user_id']]);
$user = $query->fetch();

$query = $pdo->prepare("SELECT book_id FROM ranted WHERE user_id = :user_id");
$query->execute([':user_id' => $_SESSION['user_id']]);
$books = $query->fetchAll();

$rentedBooks = [];
foreach ($books as $book) {
    $query = $pdo->prepare("SELECT title, author_id, cover FROM books WHERE id = :id");
    $query->execute([':id' => $book['book_id']]);
    $book_ = $query->fetch();
    $query = $pdo->prepare("SELECT full_name FROM authors WHERE id = :id");
    $query->execute([':id' => $book_['author_id']]);
    $author = $query->fetch();
    $rentedBooks[] = $book_ + $author + $book;
}

ob_start();
?>

<div class="wrapper">
    <div class="user_card">
        <?php if ($user['avatar']): ?>
            <img src="" alt="Фото пользователя">
        <?php else: ?>
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR-DSW54utMSZ6J1F9luVr6YYDoRZ-FQYCL3w&s" alt="Фото пользователя">
        <?php endif; ?>
        <h2 class="fio"><?= $user['full_name'] ?></h2>
        <span class="email"><?= $user['email'] ?></span>
        <a href="../pages/user_edit.php" class="btn">Редактировать</a>
    </div>
    <div class="user_rented">
        <?php foreach ($rentedBooks as $book): ?>
            <div class="book">
                <img src="../public/books/<?= $book['cover'] ?>" alt="Обложка книги" class="cover">
                <h2 class="book_title"><?= $book['title'] ?></h2>
                <span class="book_author"><?= $book['full_name'] ?></span>
                <a href="./books.php?id=<?= $book['book_id'] ?>" class="btn">Подробнее</a>
                <a href="../handlers/books/unrented.php?id=<?= $book['book_id'] ?>" class="btn">Удалить</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
$content = ob_get_clean();
require "../templates/header.php";
echo $content;
require "../templates/footer.php";
?>
