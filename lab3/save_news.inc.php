<?php


// Проверка, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Проверка заполнения всех полей формы
    if (empty($_POST['title']) || empty($_POST['category']) || empty($_POST['description']) || empty($_POST['source']))
        $errMsg = "Заполните все поля формы!";
    else {
        // Фильтрация полученных данных
        $title = trim(strip_tags($_POST['title']));
        $category = intval($_POST['category']);
        $description = trim(strip_tags($_POST['description']));
        $source = trim(strip_tags($_POST['source']));
        
        // Вызов метода saveNews()
        // успех - перезапрос страницы
        if ($news->saveNews($title, $category, $description, $source)) {
            
            header("Location: news.php");
            exit;
        } else
            $errMsg = "Произошла ошибка при добавлении новости";
        
    }
}