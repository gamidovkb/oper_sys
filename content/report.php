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

// Запрос для получения количества звонков
$sqlCalls = "SELECT COUNT(*) AS totalCalls FROM calls";
$resultCalls = $conn->query($sqlCalls);
$totalCalls = $resultCalls->fetch_assoc()['totalCalls'];

// Запрос для получения количества задач
$sqlTasks = "SELECT COUNT(*) AS totalTasks FROM tasks";
$resultTasks = $conn->query($sqlTasks);
$totalTasks = $resultTasks->fetch_assoc()['totalTasks'];

// Закрытие соединения с базой данных
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Отчет</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../nav.css">
    <style>
        .report-table {
            width: 400px;
            margin: 20px auto;
            border-collapse: collapse;
        }

        .report-table th,
        .report-table td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        .report-table th {
            background-color: #f5f5f5;
        }

        .report-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .report-table tr:hover {
            background-color: #e0e0e0;
        }
		.container {
			justify-content: initial;
			align-items: initial;
			height: initial;
		}

    </style>
</head>
<body>
    <?php include('../nav.php'); ?>

    <div class="admin-panel">
        <h2>Отчет</h2>
    </div>

    <div class="container">
        <div class="content">
            <h3>Статистика</h3>
            <table class="report-table">
                <tr>
                    <th>Количество звонков</th>
                    <td><?php echo $totalCalls; ?></td>
                </tr>
                <tr>
                    <th>Количество задач</th>
                    <td><?php echo $totalTasks; ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
