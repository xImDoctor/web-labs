<?php
declare(strict_types=1);


spl_autoload_register();

use Singleton\Settings;

// Settings::get()->items_per_page = 20;
// echo Settings::get()->items_per_page; // 20

Settings::get()->max_connections = 100;
Settings::get()->database_name = 'lab2_Database';
Settings::get()->is_maintenance = false;

echo "<p><strong>Числовое значение:</strong> Максимум подключений = " . Settings::get()->max_connections . "</p>";
echo "<p><strong>Строковое значение:</strong> База данных = " . Settings::get()->database_name . "</p>";
echo "<p><strong>Логическое значение:</strong> Режим обслуживания = " . (Settings::get()->is_maintenance ? 'true' : 'false') . "</p>";

echo "<hr>";
echo "<h3>Проверка работы паттерна</h3>";

$settings1 = Settings::get();
$settings2 = Settings::get();

echo '<p>$settings1 = Settings::get();</p>';
echo '<p>$settings2 = Settings::get();</p>';
echo '<p>$settings1 === $settings2 ? \'Да\' : \'Нет\';</p>';

echo "<p>Первый экземпляр и второй экземпляр - это один и тот же объект? <strong>" . 
     ($settings1 === $settings2 ? 'Да' : 'Нет') . "</strong></p>";
echo "<p>Значение из первого экземпляра: " . $settings1->database_name . "</p>";
echo "<p>Значение из второго экземпляра: " . $settings2->database_name . "</p>";