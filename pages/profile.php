<?php
session_start();
$page_title = "Профиль";

require "../config/db.php";
$query = $pdo->prepare(
        "SELECT * FROM users WHERE id = :id"
);
$query->execute([':id' => $_SESSION['user_id']]);
$user = $query->fetch();

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
</div>

<?php
$content = ob_get_clean();
require "../templates/header.php";
echo $content;
require "../templates/footer.php";
?>
