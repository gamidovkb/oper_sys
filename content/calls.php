<!DOCTYPE html>
<html>
<head>
    <title>Система для операторов - Звонки</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../nav.css">
    <link rel="stylesheet" type="text/css" href="calls_style.css">
    <style>
        .call-list table {
            width: 100%;
            border-collapse: collapse;
        }

        .call-list table th,
        .call-list table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .call-list table th {
            background-color: #b2d7ff;
        }

        .call-list table tr:nth-child(even) {
            background-color: #d2d2d2;
        }

        .call-list table tr:hover {
            background-color: #a5a5a5;
        }
    </style>
</head>
<body>
    <?php include('../nav.php'); ?>
    
    <div class="dashboard">
        <h2>Звонки</h2>
        <p>Здесь вы можете просмотреть информацию о звонках.</p>
        
        <div class="call-list">
            <h3>Список звонков</h3>
            <?php
            // Подключение к базе данных (замените значения на свои)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "tabel_prihoda";

            // Создание подключения
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Проверка соединения
            if ($conn->connect_error) {
                die("Ошибка подключения к базе данных: " . $conn->connect_error);
            }

            // Определение количества строк на странице
            $rowsPerPage = 15;

            // Определение текущей страницы
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

            // Вычисление оффсета для выборки данных
            $offset = ($currentPage - 1) * $rowsPerPage;

            // SQL-запрос для выборки звонков с пагинацией
            $sql = "SELECT * FROM calls LIMIT $offset, $rowsPerPage";

            // Выполнение запроса
            $result = $conn->query($sql);

            // Проверка наличия данных
            if ($result->num_rows > 0) {
                // Вывод списка звонков в виде таблицы
                echo "<table>";
                echo "<tr><th>Имя</th><th>Номер</th><th>Тип звонка</th><th>Длительность</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    $callerName = $row['caller_name'];
                    $callerNumber = $row['caller_number'];
                    $callType = $row['call_type'];
                    $callDuration = $row['call_duration'];

                    echo "<tr>";
                    echo "<td>$callerName</td>";
                    echo "<td>$callerNumber</td>";
                    echo "<td>$callType</td>";
                    echo "<td>$callDuration sec</td>";
                    echo "</tr>";
                }
                echo "</table>";

                // SQL-запрос для подсчета общего количества звонков
                $countSql = "SELECT COUNT(*) AS total FROM calls";
                $countResult = $conn->query($countSql);
                $totalCount = $countResult->fetch_assoc()['total'];

                // Вычисление общего количества страниц
                $totalPages = ceil($totalCount / $rowsPerPage);

                // Вывод пагинации
                echo "<div class='pagination'>";
                if ($currentPage > 1) {
                    echo "<a href='calls.php?page=" . ($currentPage - 1) . "'>&laquo; Предыдущая</a>";
                }
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($i == $currentPage) {
                        echo "<a class='active' href='calls.php?page=$i'>$i</a>";
                    } else {
                        echo "<a href='calls.php?page=$i'>$i</a>";
                    }
                }
                if ($currentPage < $totalPages) {
                    echo "<a href='calls.php?page=" . ($currentPage + 1) . "'>Следующая &raquo;</a>";
                }
                echo "</div>";
            } else {
                echo "Нет доступных звонков.";
            }

            // Закрытие соединения с базой данных
            $conn->close();
            ?>
        </div>
        
        <div class="call-form">
            <h3>Добавить фиктивные звонки</h3>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="number" name="count" placeholder="Количество звонков">
                <input type="submit" name="submit" value="Добавить">
            </form>
        </div>
        
        <?php
        // Подключение к базе данных (замените значения на свои)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "tabel_prihoda";

        // Обработка отправки формы для добавления фиктивных звонков
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            $count = $_POST['count'];

            // Создание подключения
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Проверка соединения
            if ($conn->connect_error) {
                die("Ошибка подключения к базе данных: " . $conn->connect_error);
            }

            // Фиктивные данные для звонков
            $callers = array(
                array("John Doe", "1234567890", "Incoming", 120),
                array("Jane Smith", "9876543210", "Outgoing", 180),
                // ... добавьте остальные фиктивные данные
            );

            // Вставка фиктивных звонков в таблицу
            for ($i = 0; $i < $count; $i++) {
                $caller = $callers[$i % count($callers)];
                $callerName = $caller[0];
                $callerNumber = $caller[1];
                $callType = $caller[2];
                $callDuration = $caller[3];

                $sql = "INSERT INTO calls (caller_name, caller_number, call_type, call_duration) VALUES ('$callerName', '$callerNumber', '$callType', $callDuration)";

                if ($conn->query($sql) === TRUE) {
                    echo "Звонок успешно добавлен.<br>";
                } else {
                    echo "Ошибка при добавлении звонка: " . $conn->error . "<br>";
                }
            }

            // Закрытие соединения с базой данных123
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
