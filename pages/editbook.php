<?php
$page_title = "Добавление книг";
session_start();
require "../config/db.php";

$query = $pdo->prepare("SELECT * FROM books WHERE id = :id");
$query->execute([":id" => $_GET['id']]);
$book = $query->fetch();

$query = $pdo->prepare("SELECT full_name FROM authors WHERE id = :id");
$query->execute([":id" => $book['author_id']]);
$author = $query->fetch();

ob_start();
?>
<div class="wrapper">
    <form action="../handlers/books/edit.php" method="post" class="reg_form" enctype="multipart/form-data">
        <input type="text" value="<?= $book['id'] ?>" name="id" class="input_hidden">
        <label>
            <span class="placeholder">Введите название книги</span>
            <input type="text" name="title" value="<?= $book['title'] ?>">
        </label>
        <label>
            <span class="placeholder">Введите описание книги</span>
            <textarea name="description" ><?= $book['description'] ?></textarea>
        </label>
        <label>
            <span class="placeholder">Введите год выпуска книги</span>
            <input type="number" min="1200" step="1" name="year" value="<?= $book['year'] ?>">
        </label>
        <label>
            <span class="placeholder">Введите автора</span>
            <input type="text" name="authorId" list="authors" value="<?= $author['full_name'] ?>">
        </label>
        <label>
            <span class="placeholder">Выберите обложку для книги</span>
            <input type="file" name="cover">
        </label>
        <input type="submit" value="Изменить книгу">
        <?= $_SESSION['error'] ?? "" ?>
    </form>
</div>

<?php
$content = ob_get_clean();
require "../templates/header.php";
echo $content;
require "../templates/footer.php";
?>