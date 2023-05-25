<?php
session_start(); // Инициализация сессии
session_destroy(); // Сброс сессии

header("Location: index.php"); // Перенаправление на страницу входа
exit();
?>
