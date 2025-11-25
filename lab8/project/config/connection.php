<?php
/**
 * Файл подключения к базе данных
 * Задание I.4
 * 
 * Этот файл создает PDO соединение с базой данных MySQL
 * и возвращает объект $pdo для использования в моделях
 */

require_once("SECRETS.php");

$host = BD_HOST;                
$dbname = BD_NAME;         
$user = BD_USER;                
$pass = BD_PASS;              
$charset = 'utf8mb4';                   // Кодировка (utf8mb4 для поддержки emoji)


// DSN (Data Source Name) для PDO
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$options = [
    // Режим обработки ошибок: выбрасывать исключения
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    
    // Режим выборки по умолчанию: ассоциативный массив
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    
    // Отключить эмуляцию prepared statements (для безопасности)
    PDO::ATTR_EMULATE_PREPARES   => false,
];


// Попытка подключения к БД
try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // echo "Подключение к БД успешно!<br>";
    
} catch (PDOException $e) {
    // Ошибка подключения
    die('
        <h1>Ошибка подключения к базе данных</h1>
        <p><strong>Сообщение:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>
        <p><strong>Проверьте:</strong></p>
        <ul>
            <li>Правильно ли указаны параметры в /project/config/connection.php?</li>
            <li>Создана ли база данных в PhpMyAdmin?</li>
            <li>Существует ли пользователь с указанным логином и паролем?</li>
            <li>Имеет ли пользователь права доступа к БД?</li>
        </ul>
        <hr>
        <p><small>Файл: ' . __FILE__ . '</small></p>
    ');
}

return $pdo;
