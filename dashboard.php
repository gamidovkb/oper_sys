<?php
session_start(); // Инициализация сессии

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Перенаправление на страницу входа, если пользователь не авторизован
    exit(); // Завершение выполнения скрипта
}

$username = $_SESSION['username'];

// Подключение к базе данных
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "tabel_prihoda";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

// Получение данных пользователей из таблицы users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Закрытие соединения с базой данных
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Система для операторов - Дашборд</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="nav.css">
	<style>
        .dashboard-content {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <?php include('nav.php'); ?>
    
    <div class="dashboard">
        <h2>Добро пожаловать, <?php echo $username; ?>!</h2>
        
        <div class="dashboard-content">
            <h3>Информация о пользователях:</h3>
            <table>
                <tr>
                    <th>ID</th>
					<th>Имя</th>
                    <th>Email</th>
					<th>pass</th>
                </tr>
					<?php
					if ($result->num_rows > 0) {
						while ($row = $result->fetch_assoc()) {
							echo "<tr>";
							echo "<td>" . ($row["id"] ? $row["id"] : "-") . "</td>";
							echo "<td>" . ($row["username"] ? $row["username"] : "-") . "</td>";
							echo "<td>" . ($row["email"] ? $row["email"] : "-") . "</td>";
							echo "<td>" . ($row["password"] ? $row["password"] : "-") . "</td>";
							echo "</tr>";
						}
					} else {
						echo "<tr><td colspan='4'>Нет доступных данных</td></tr>";
					}
					?>

            </table>
        </div>
    </div>
	
</body>
</html>
