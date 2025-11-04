<?php
declare(strict_types=1);

require_once 'NewsDB.class.php';

$news = new NewsDB();
$errMsg = "";

// Проверка на удаление записи
if (isset($_GET['del_id']))
	require_once 'delete_news.inc.php';

// была ли отправлена HTML-форма
if ($_SERVER['REQUEST_METHOD'] == 'POST')
	require_once 'save_news.inc.php';

// Проверка существования RSS файла
$rssExists = file_exists(NewsDB::RSS_NAME);
?>

<!DOCTYPE html>
<html>

<head>
	<title>Новостная лента с RSS</title>
	<meta charset="utf-8">
	<link rel="alternate" type="application/rss+xml" title="RSS" href="<?= NewsDB::RSS_NAME ?>">
	<link rel="stylesheet" href="css/news.css">
</head>

<body>

	<h1>
		Последние новости
		<?php if ($rssExists): ?>
			<a href="<?= NewsDB::RSS_NAME ?>" class="rss-link" title="RSS лента">RSS Feed</a>
		<?php endif; ?>
	</h1>

	<p>
		<a href="uml.html" class="uml-link">Диаграмма классов</a>
	</p>

	<div class="info-box">
		<h3>XML и RSS генерация</h3>
		<p>Приложение автоматически генерирует RSS-ленту при добавлении или удалении новостей.</p>
		<p>RSS файл создается с помощью <strong>DOM API</strong> и сохраняется как <code><?= NewsDB::RSS_NAME ?></code></p>
		<p>Каждая новость содержит: заголовок, ссылку, описание (в CDATA), дату публикации и категорию.</p>
	</div>

	<?php
	// Проверка и вывод ошибок
	if (!empty($errMsg))
		echo "<div class='error'>$errMsg</div>";
	?>

	<form action="<?= $_SERVER['PHP_SELF']; ?>" method="post">
		<label>Заголовок новости:</label><br>
		<input type="text" name="title" required><br>

		<label>Выберите категорию:</label><br>
		<select name="category" required>
			<option value="">-- Выберите категорию --</option>
			<?php
			// Использование объекта $news как итератора для вывода категорий
			foreach($news as $id => $categoryName)
				echo "<option value=\"$id\">$categoryName</option>\n";
			?>
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
		require_once 'get_news.inc.php';  //  файл для вывода новостей
		?>
	</div>
	

</body>

</html>
