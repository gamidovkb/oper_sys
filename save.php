<?php
// Проверка наличия параметров "page" и "content" в POST-запросе
if (isset($_POST['page']) && isset($_POST['content'])) {
    $page = $_POST['page'];
    $content = $_POST['content'];

    // Сохранение изменений в файле
    file_put_contents($pagesDirectory . $page, $content);

    // Перенаправление обратно на страницу редактирования
    header('Location: edit.php?page=' . $page);
    exit();
} else {
    echo 'Ошибка сохранения изменений.';
}
?>
