<?php
// Подключение к базе данных (замените значения на ваши)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tabel_prihoda";

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка соединения: " . $conn->connect_error);
}

// Запрос для выборки задач из таблицы tasks
$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);

// Количество задач на странице
$tasksPerPage = 10;

// Получение общего количества задач
$totalTasks = $result->num_rows;

// Вычисление общего количества страниц
$totalPages = ceil($totalTasks / $tasksPerPage);

// Получение текущей страницы из параметра URL (например, ?page=2)
$currentpage = isset($_GET['page']) ? $_GET['page'] : 1;

// Вычисление смещения (OFFSET) для SQL-запроса
$offset = ($currentpage - 1) * $tasksPerPage;

// Запрос для выборки задач с учетом пагинации
$sql = "SELECT * FROM tasks LIMIT $offset, $tasksPerPage";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Задачи</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
	<link rel="stylesheet" type="text/css" href="../nav.css">
    <link rel="stylesheet" type="text/css" href="tasks_css.css">
    
</head>
<body>
    <?php include('../nav.php'); ?>

    <div class="admin-panel">
        <h2>Задачи</h2>
    </div>

    <div class="container">
        <div class="content">
            <h3>Список задач</h3>
			<div class="task-list">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Статус</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    // Вывод задач
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Нет задач.</td></tr>";
                }
                ?>
            </table>
			</div>

            <div class="pagination">
                <?php
                // Вывод ссылок на страницы
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a href='tasks.php?page=$i'>$i</a> ";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Закрытие соединения с базой данных
$conn->close();
?>
