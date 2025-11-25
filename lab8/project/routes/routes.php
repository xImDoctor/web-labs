<?php
/**
 * Файл маршрутизации
 * 
 * Определяет соответствие между URL и контроллерами/действиями
 * Каждый роут создается с помощью объекта Route
 * 
 * Формат: new Route(URL_шаблон, контроллер, действие)
 * 
 * Параметры в URL обозначаются двоеточием: :param
 */

use Core\Route;

return [
    // Приветственная страница
    new Route('/hello/', 'hello', 'index'),
    

    // TestController - II.1
    new Route('/test/act1/', 'test', 'act1'),
    new Route('/test/act2/', 'test', 'act2'),
    new Route('/test/act3/', 'test', 'act3'),
    
    // NumController - II.2
    // /nums/5/10/15/ → сумма 30
    new Route('/nums/:n1/:n2/:n3/', 'num', 'sum'),
    
    // ================================================
    // UserController - II.3-7
    // Показать пользователя по ID
    // /user/1/
    new Route('/user/:id/', 'user', 'show'),
    
    // Показать конкретное поле пользователя
    // /user/2/name/
    new Route('/user/:id/:key/', 'user', 'info'),
    
    // Показать всех пользователей
    new Route('/user/all/', 'user', 'all'),
    
    // Показать первых N пользователей
    // Пример: /user/first/3/
    new Route('/user/first/:n/', 'user', 'first'),
    
    // ProductController - III.1-4 (с массивом)
    // Показать продукт по номеру в массиве
    //  /product/1/
    new Route('/product/:n/', 'product', 'show'),
    
    // Показать все продукты (таблица)
    new Route('/products/all/', 'product', 'all'),
    
    // ProductController - VII.8 (с БД)
    // Показать продукт по ID из БД
    // /product/db/1/
    new Route('/product/db/:id/', 'product', 'showFromDb'),
    
    // Показать все продукты из БД
    new Route('/products/db/', 'product', 'allFromDb'),
    
    // PageController - IV.3 (с массивом)
    // Показать страницу из массива
    // /page/array/1/
    new Route('/page/array/:id/', 'page', 'showFromArray'),
    
    // PageController - VI.2 (тестирование модели)
    new Route('/page/test/', 'page', 'test'),
    
    // PageController - VII.1-7 (с БД)
    // Показать одну страницу из БД
    // Пример: /page/1/
    new Route('/page/:id/', 'page', 'one'),
    
    // Показать список всех страниц из БД
    new Route('/pages/', 'page', 'all'),
    

  // Доп роуты

    // Главная страница
    new Route('/', 'page', 'all'),
    
    // Роут для index.php
    new Route('/index.php', 'page', 'all'),
];