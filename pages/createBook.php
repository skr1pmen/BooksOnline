<?php
$page_title = "Добавление книг";
session_start();
require "../config/db.php";

$query = $pdo->prepare("SELECT full_name FROM authors ORDER BY id");
$query->execute();
$authors = $query->fetchAll();

ob_start();
?>
<div class="wrapper">
    <form action="../handlers/books/create.php" method="post" class="reg_form" enctype="multipart/form-data">
        <label>
            <span class="placeholder">Введите название книги</span>
            <input type="text" name="title">
        </label>
        <label>
            <span class="placeholder">Введите описание книги</span>
            <textarea name="description"></textarea>
        </label>
        <label>
            <span class="placeholder">Введите год выпуска книги</span>
            <input type="number" min="1200" step="1" name="year">
        </label>
        <label>
            <span class="placeholder">Введите автора</span>
            <input type="text" name="authorId" list="authors">
            <datalist id="authors">
                <?php foreach ($authors as $author): ?>
                    <option value="<?= $author['full_name'] ?>"><?= $author['full_name'] ?></option>
                <?php endforeach; ?>
            </datalist>
        </label>
        <label>
            <span class="placeholder">Выберите обложку для книги</span>
            <input type="file" name="cover">
        </label>
        <input type="submit" value="Создать книгу">
        <?= $_SESSION['error'] ?? "" ?>
    </form>
</div>

<?php
$content = ob_get_clean();
require "../templates/header.php";
echo $content;
require "../templates/footer.php";
?>