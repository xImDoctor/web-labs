<?php
declare(strict_types=1);


session_start();

// Создание изображения по noise.jpg
$image = imagecreatefromjpeg('noise.jpg');


if (!$image)
    die('Ошибка загрузки noise.jpg');


// Создание цвета для рисования текста
$textColor = imagecolorallocate($image, 50, 50, 50);

// Параметры отрисовки
$fontSize = rand(18, 30);          // Размер шрифта от 18 до 30 пт
$charSpacing = 40;                          // Расстояние между символами
$startX = 20;                               // Начальная x
$startY = 30;                               // Начальная y


// Генерация случайной уникальной строки
// буквы и цифры кроме похожих: 0, O, I, l
$characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$captchaLength = rand(5, 6);            // Длина строки 5-6 символов
$captchaText = '';

for ($i = 0; $i < $captchaLength; $i++)
    $captchaText .= $characters[rand(0, strlen($characters) - 1)];


// Массив для доступных шрифтов
$fonts = [
    'fonts/bellb.ttf',
    'fonts/georgia.ttf'
];


// Посимвольная отрисовка строки
$currentX = $startX;
for ($i = 0; $i < strlen($captchaText); $i++) {
    $char = $captchaText[$i];
    
    $charSize = rand(18, 30);              // Размер символа
    $charAngle = rand(-25, 25);            // Угол наклона
    $charFont = $fonts[array_rand($fonts)];   // Случайный шрифт
    
    // Случайное смещение по y для каждого символа
    $charY = $startY + rand(-5, 5);
    


    // Случайный цвет (темные оттенки)
    $charColor = imagecolorallocate($image, rand(0, 100),
                                     rand(0, 100), rand(0, 100));
    

    // Отрисовка полученного символа
    imagettftext(
        $image,
        $charSize,
        $charAngle,
        $currentX,
        $charY,
        $charColor,
        $charFont,
        $char
    );
    
    // Сдвиг под след символ
    $currentX += $charSpacing;
}




$_SESSION['captcha'] = $captchaText;
$_SESSION['captcha_enabled'] = true;  // Флаг, что картинки включены

// Отдача изображения в jpeg с 50% сжатием
header('Content-Type: image/jpeg');
imagejpeg($image, null, 50);


// Очистка памяти
imagedestroy($image);