<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['filename'])) {
    $filename = $_GET['filename'];
    $pagesDirectory = 'content/';

    // Проверка существования файла
    if (file_exists($pagesDirectory . $filename)) {
        // Чтение содержимого файла
        $content = file_get_contents($pagesDirectory . $filename);
        echo $content;
    } else {
        echo 'Файл не найден.';
    }
}
?>
