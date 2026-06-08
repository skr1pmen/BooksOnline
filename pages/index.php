<?php
$page_title = "Главная";
ob_start();
session_start();
//var_dump($_SESSION);
?>

<div class="wrapper">
    <div class="search">
        <form class="search_form" action="../handlers/search.php" method="get">
            <input class="search_input" type="text" placeholder="Поиск">
            <input class="btn" type="submit" value="Найти">
        </form>
    </div>
    <div class="books">
        
    </div>
</div>

<?php
$content = ob_get_clean();
require_once "../templates/header.php";
echo $content;
require_once "../templates/footer.php";
?>