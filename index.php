<!DOCTYPE html>
<html>
<head>
    <title>Система для операторов</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <div class="login-form">
            <h2>Авторизация</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="text" name="username" placeholder="Логин" required><br>
                <input type="password" name="password" placeholder="Пароль" required><br>
                <input type="submit" value="Войти">
            </form>
        </div>
    </div>
<?php
session_start(); // Инициализация сессии

// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tabel_prihoda";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Проверка отправки формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Поиск пользователя в базе данных
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Пользователь найден, устанавливаем сессию
        $_SESSION['username'] = $username;
        header("Location: dashboard.php"); // Перенаправление на дашборд после успешной аутентификации
    } else {
        // Неверные логин или пароль, выводим сообщение об ошибке
        echo "<p>Неверные логин или пароль.</p>";
    }
}

$conn->close();
?>
</body>
</html>
