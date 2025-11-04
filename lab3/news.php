<?php
declare(strict_types=1);

// Подключение файла с описанием класса NewsDB
require_once 'NewsDB.class.php';

// Создание объекта $news, экземпляр класса NewsDB
$news = new NewsDB();

// Создание переменной $errMsg со строковым значением ""
$errMsg = "";

// Проверка на удаление записи
if (isset($_GET['del_id'])) {
	require_once 'delete_news.inc.php';
}

// Проверка, была ли отправлена HTML-форма
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require_once 'save_news.inc.php';
}
?>


<!DOCTYPE html>
<html>

<head>
	<title>Новостная лента</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/news.css">
</head>

<body>

	<h1>Последние новости</h1>

	<?php

	// Проверка и вывод ошибок
	if (!empty($errMsg)) {
		echo "<div class='error'>$errMsg</div>";
	}
	?>

	<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
		<label>Заголовок новости:</label><br>
		<input type="text" name="title" required><br>

		<label>Выберите категорию:</label><br>
		<select name="category" required>
			<option value="">-- Выберите категорию --</option>
			<option value="1">Политика</option>
			<option value="2">Культура</option>
			<option value="3">Спорт</option>
		</select>
		<br />

		<label>Текст новости:</label><br>
		<textarea name="description" cols="50" rows="5" required></textarea><br>

		<label>Источник:</label><br>
		<input type="text" name="source" required><br>
		<br>

		<input type="submit" value="Добавить!">
	</form>

	<div class="news-container">


		<?php
		require_once 'get_news.inc.php';  // Подключение файла для вывода новостей
		?>

	</div>
</body>

</html>