<?php 
declare(strict_types=1);

session_start();

// сообщение
$message = '';
$messageType = '';  // 'success', 'error', 'warning'


// Проверка метода отправки
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Проверка не отключен ли показ картинок в браузере
    if (!isset($_SESSION['captcha_enabled'])) {
        $message = 'Пожалуйста, включите отображение изображений в вашем браузере.';
        $messageType = 'warning';
    } else {


        // Получение введенного пользователем ответа
        $userAnswer = $_POST['answer'] ?? '';
        

        // Удаление пробелов и приведение к верхнему регистру
        $userAnswer = strtoupper(trim($userAnswer));
        

        // Получение правильного ответа из сессии
        $correctAnswer = $_SESSION['captcha'] ?? '';
        

        // Проверка введенных данных
        if (empty($userAnswer)) {

            $message = 'Пожалуйста, введите символы с изображения!';
            $messageType = 'error';

        } elseif ($userAnswer === $correctAnswer) {

            $message = 'Отлично! Вы ввели правильную строку: ' . htmlspecialchars($correctAnswer);
            $messageType = 'success';
            
            // Очистка сессии после успешной проверки
            unset($_SESSION['captcha']);

        } else {
            $message = 'Неправильно! Вы ввели: "' . htmlspecialchars($userAnswer) . 
                      '", а правильный ответ: "' . htmlspecialchars($correctAnswer) . '"';
            $messageType = 'error';
        }
    }

}
?>

<!DOCTYPE HTML>
<html>

<head>
  <meta charset="utf-8">
  <title>Регистрация с CAPTCHA</title>
  <link rel="stylesheet" href="css/reg-style.css">
</head>

<body>
  <div class="container">
    <h1>Регистрация</h1>
    
    <div class="info">
      Введите символы, которые видите на изображении ниже (CAPTCHA).
    </div>
    
    <form action="" method="post">
      <div class="captcha-box">
        <img src="noise-picture.php?<?php echo time(); ?>" alt="CAPTCHA">
        <div class="reload-link">
          <a href="javascript:location.reload()">Обновить картинку</a>
        </div>
      </div>
      
      <div class="form-group">
        <label for="answer">Введите символы с изображения:</label>
        <input type="text" name="answer" id="answer" size="6" maxlength="6" 
               placeholder="XXXXX" autocomplete="off" required>
      </div>
      
      <input type="submit" value="Подтвердить">
    </form>
    

    <?php if ($message): ?>
    <div class="message <?php echo $messageType; ?>">
      <?php echo $message; ?>
    </div>
    <?php endif; ?>
    

    <div class="info" style="margin-top: 30px;">
      <ul style="margin: 10px 0; padding-left: 20px;">
        <li>Регистр не имеет значения</li>
        <li>Только латинские буквы и цифры</li>
        <li>Символы 0/O, I/l исключены</li>
        <li>Если не видно - обновите страницу</li>
      </ul>
    </div>
  </div>
</body>

</html>