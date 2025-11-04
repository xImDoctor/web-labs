<?php
// Вызов метода getNews()
$newsItems = $news->getNews();

// Проверка успешности запроса
if ($newsItems === false) {
    $errMsg = "Произошла ошибка при выводе новостной ленты";
} else {
    // Получение количества записей
    $count = count($newsItems);
    
    if ($count > 0) {
        echo "<h2>Всего новостей: $count</h2>";
        
        // Вывод новостей с помощью цикла
        foreach ($newsItems as $item) {
            $id = $item['id'];
            $title = htmlspecialchars($item['title']);
            $category = htmlspecialchars($item['category']);
            $description = nl2br(htmlspecialchars($item['description']));
            $source = htmlspecialchars($item['source']);
            $datetime = date("d.m.Y H:i:s", $item['datetime']);
            
            // Вывод новости
            echo <<<HTML
            <div style="border: 1px solid #ccc; margin: 10px 0; padding: 10px; border-radius: 5px;">
                <h3>$title</h3>
                <p><strong>Категория:</strong> $category</p>
                <p>$description</p>
                <p><strong>Источник:</strong> $source</p>
                <p><small>Дата: $datetime</small></p>
                <p>
                    <a href="news.php?id=$id" style="color: blue;">Подробнее</a> | 
                    <a href="news.php?del_id=$id" style="color: red;" 
                       onclick="return confirm('Вы уверены, что хотите удалить эту новость?')">Удалить</a>
                </p>
            </div>
            HTML;
        }
    } else
        echo "<p>Новостей пока нет</p>";

}
