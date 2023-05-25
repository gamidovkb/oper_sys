<?php
// Путь к директории с страницами
$pagesDirectory = 'content/';

// Получение списка файлов страниц
$files = scandir($pagesDirectory);

// Исключение "." и ".." из списка файлов
$files = array_diff($files, array('.', '..'));

// Обработка отправки формы для сохранения изменений
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $page = $_POST['page'];
    $content = $_POST['content'];

    // Проверка существования файла страницы
    if (file_exists($pagesDirectory . $page)) {
        // Сохранение изменений в файле
        file_put_contents($pagesDirectory . $page, $content);
        echo 'Изменения сохранены.';
    } else {
        echo 'Страница не найдена.';
    }
}

// Обработка отправки формы для создания страницы
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $newPage = $_POST['new_page'];

    // Проверка существования файла страницы
    if (!empty($newPage) && !file_exists($pagesDirectory . $newPage)) {
        // Создание нового файла страницы
        file_put_contents($pagesDirectory . $newPage, '');
        echo 'Страница успешно создана.';
    } else {
        echo 'Ошибка создания страницы. Убедитесь, что имя страницы уникально и не пустое.';
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Административная панель</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="nav.css">
    <link rel="stylesheet" type="text/css" href="admin_css.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

			<script>
			  $(document).ready(function() {
				// Получение содержимого файла для редактирования
				function getFileContent(filename) {
				  $.get("get_file_content.php", { filename: filename }, function(response) {
					$("#edit-content").val(response);
					$("#edit-page-name").text(filename); // Добавленная строка
					$("input[name=page]").val(filename); // Добавленная строка
				  });
				}

				// Обработчик клика на кнопке "Редактировать"
				$(".edit-button").click(function() {
				  var filename = $(this).data("filename");
				  getFileContent(filename);
				});
			  });
			</script>

</head>
<body>
<?php include('nav.php'); ?>

<div class="admin-panel">
    <h2>Административная панель</h2>
</div>

<div class="container">
    <div class="sidebar">
        <h3>Редактирование страниц:</h3>
        <table>
            <tr>
                <th>Имя файла</th>
                <th>Размер файла</th>
                <th>Дата последнего изменения</th>
                <th></th>
            </tr>
            <?php foreach ($files as $file) : ?>
                <?php
                $filePath = $pagesDirectory . $file;
                $fileSize = filesize($filePath);
                $fileModified = date("d.m.Y H:i:s", filemtime($filePath));
                ?>
                <tr>
                    <td><?php echo $file; ?></td>
                    <td><?php echo $fileSize; ?> байт</td>
                    <td><?php echo $fileModified; ?></td>
                    <td><button class="edit-button" data-filename="<?php echo $file; ?>">Редактировать</button></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="content">
        <?php if (isset($_GET['page'])) : ?>
            <?php
            $page = $_GET['page'];

            // Проверка существования файла страницы
            if (file_exists($pagesDirectory . $page)) {
                $content = file_get_contents($pagesDirectory . $page);
            } else {
                echo 'Страница не найдена.';
                exit;
            }
            ?>

            <div id="edit-page-title">
                <?php include('edit.php'); ?>
            </div>

            <script>
              var currentPage = "<?php echo $page; ?>";
              document.getElementById("edit-page-name").textContent = currentPage;
            </script>
				<?php else: ?>
					<h3 id="edit-page-title">Редактирование страницы: <span id="edit-page-name"></span></h3>
					<div class="edit-window">
						<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<input type="hidden" name="page" value="">
							<textarea id="edit-content" name="content"></textarea><br>
							<input type="submit" value="Сохранить изменения">
						</form>
					</div>
				<?php endif; ?>


        <div class="create-page">
            <h3>Создание новой страницы:</h3>
            <form class="create-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="text" name="new_page" placeholder="Имя страницы">
                <input type="submit" name="create" value="Создать">
            </form>
        </div>
    </div>
</div>
</body>
</html>
