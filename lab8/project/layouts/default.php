<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Заголовок страницы (IV.1) -->
    <!-- Переменная $title устанавливается в контроллерах через $this->title -->
    <title><?= htmlspecialchars($title ?? 'MVC Фреймворк') ?></title>
    
    <!-- Подключение CSS (задание V.1) -->
    <link rel="stylesheet" href="<?= BASE_PATH ?>/project/webroot/css/styles.css">
    
    <!-- Дополнительные мета-теги -->
    <meta name="description" content="Лабораторная работа №8 - MVC Фреймворк">
    <meta name="author" content="Andrew">
</head>
<body>
    
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <h1 class="site-logo">
                    <a href="<?= BASE_PATH ?>/">MVC Фреймворк</a>
                </h1>
                <nav class="main-nav">
                    <ul>
                        <li><a href="<?= BASE_PATH ?>/">Главная</a></li>
                        <li><a href="<?= BASE_PATH ?>/welcome/">Приветствие</a></li>
                        <li><a href="<?= BASE_PATH ?>/products/all/">Продукты</a></li>
                        <li><a href="<?= BASE_PATH ?>/user/all/">Пользователи</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    
    <div class="container">
        <div class="layout-wrapper">
            <!-- Левый сайдбар -->
            <aside class="sidebar left">
                <div class="sidebar-content">
                    <h3>Навигация</h3>
                    <ul class="sidebar-menu">
                        <li><strong>Test Controller:</strong></li>
                        <li><a href="<?= BASE_PATH ?>/test/act1/">Действие 1</a></li>
                        <li><a href="<?= BASE_PATH ?>/test/act2/">Действие 2</a></li>
                        <li><a href="<?= BASE_PATH ?>/test/act3/">Действие 3</a></li>
                        
                        <li><strong>Num Controller:</strong></li>
                        <li><a href="<?= BASE_PATH ?>/nums/5/10/15/">Сумма чисел</a></li>
                        
                        <li><strong>User Controller:</strong></li>
                        <li><a href="<?= BASE_PATH ?>/user/all/">Все пользователи</a></li>
                        <li><a href="<?= BASE_PATH ?>/user/1/">User #1</a></li>
                        
                        <li><strong>Product:</strong></li>
                        <li><a href="<?= BASE_PATH ?>/products/all/">Каталог</a></li>
                        
                        <li><strong>Pages (БД):</strong></li>
                        <li><a href="<?= BASE_PATH ?>/pages/">Список страниц</a></li>
                    </ul>
                </div>
            </aside>
            

            <!-- Переменная $content содержит HTML из представления -->
            <main class="main-content">
                <div class="content-wrapper">
                    <!-- Заголовок H1 -->
                    <?php if (isset($title)): ?>
                        <h1 class="page-title"><?= htmlspecialchars($title) ?></h1>
                        <hr class="title-divider">
                    <?php endif; ?>
                    
                    <!-- Основной контент из представления -->
                    <?= $content ?>
                </div>
            </main>
            
            <!-- Правый сайдбар -->
            <aside class="sidebar right">
                <div class="sidebar-content">
                    <h3>Информация</h3>
                    <div class="info-block">
                        <p><strong>Лабораторная работа №8</strong></p>
                        <p>MVC Фреймворк на PHP</p>
                        <hr>
                        <p><small>Текущая страница:</small></p>
                        <p><code><?= htmlspecialchars($_SERVER['REQUEST_URI'] ?? '/') ?></code></p>
                        <hr>
                        <p><small>Время генерации:</small></p>
                        <p><?= date('Y-m-d H:i:s') ?></p>
                    </div>
                    
                    <h3>Задания</h3>
                    <div class="info-block">
                        <ul class="checklist">
                            <li>I. Установка</li>
                            <li>II. Контроллеры</li>
                            <li>III. Представления</li>
                            <li>IV. Шаблоны</li>
                            <li>V. Ресурсы</li>
                            <li>VI. Модели</li>
                            <li>VII. Применение MVC</li>
                        </ul>
                    </div>
                </div>
            </aside>
        </div>
    </div>
    
    <footer class="site-footer">
        <div class="container">
            <div class="footer-content">
                <p>&copy; 2025 MVC Фреймворк | Лабораторная работа №8</p>
                <p>
                    <strong>Автор:</strong> Andrew | 
                    <strong>Курс:</strong> Web-программирование
                </p>
                <p>
                    <a href="https://github.com/xImDoctor/web-labs" target="_blank">
                        Репозиторий с кодом
                    </a>
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
