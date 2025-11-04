<?php

// Проверка наличия параметра del_id
if (isset($_GET['del_id'])) {

    // Прием и фильтрация полученных данных
    $id = intval($_GET['del_id']);
    
    // Проверка корректности полученных данных
    if ($id > 0) {
        // Вызов метода deleteNews()
        if ($news->deleteNews($id)) {
            // Успешное удаление - перезапрос страницы
            header("Location: news.php");
            exit;
        } else 
            $errMsg = "Произошла ошибка при удалении новости";
        
    } else {
        // Некорректные данные - перезапрос страницы
        header("Location: news.php");
        exit;
    }
}
