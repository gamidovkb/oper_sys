<?php
// Проверка наличия параметра "page" в URL
if (isset($_GET['page'])) {
    $pagesDirectory = 'content/'; // Добавленная строка

    $page = $_GET['page'];

    // Проверка существования файла страницы
    if (file_exists($pagesDirectory . $page)) {
        // Чтение содержимого файла
        $content = file_get_contents($pagesDirectory . $page);

        // Отображение содержимого файла для редактирования
        echo '<h2>Редактирование страницы: ' . $page . '</h2>';
        echo '<form action="save.php" method="post">';
        echo '<input type="hidden" name="page" value="' . $page . '">';
        echo '<textarea name="content" rows="10" cols="50">' . $content . '</textarea><br>';
        echo '<input type="submit" value="Сохранить">';
        echo '</form>';
    } else {
        echo 'Страница не найдена.';
    }
} else {
    echo 'Страница не указана.';
}
?>
