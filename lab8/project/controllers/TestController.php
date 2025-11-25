<?php
/**
 * TestController - Тестовый контроллер
 * 
 * Задание II.1: Контроллер с тремя действиями act1, act2, act3
 * Демонстрирует базовую работу MVC: контроллер получает запрос и рендерит представление
 * 
 * @package Project\Controllers
 */

namespace Project\Controllers;

use Core\Controller;

class TestController extends Controller
{
    /**
     * Действие act1
     * Доступно по адресу: /test/act1/
     * 
     * Демонстрирует контроллер с передачей данных в представление
     */
    public function act1()
    {
        // Устанавливаем заголовок страницы (title)
        $this->title = 'Действие act1 контроллера Test';
        
        // Рендерим представление test/act1.php и передаем в него данные
        return $this->render('test/act1', [
            'message' => 'Это действие act1!',
            'description' => 'Первое тестовое действие контроллера TestController',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Действие act2
     * Доступно по адресу: /test/act2/
     * 
     * Демонстрирует передачу нескольких переменных в представление
     */
    public function act2()
    {
        $this->title = 'Действие act2 контроллера Test';
        
        return $this->render('test/act2', [
            'message' => 'Это действие act2!',
            'description' => 'Второе тестовое действие контроллера TestController',
            'items' => ['Элемент 1', 'Элемент 2', 'Элемент 3'],
            'counter' => 42
        ]);
    }
    
    /**
     * Действие act3
     * Доступно по адресу: /test/act3/
     * 
     * Демонстрирует работу с более сложными данными
     */
    public function act3()
    {
        $this->title = 'Действие act3 контроллера Test';
        
        return $this->render('test/act3', [
            'message' => 'Это действие act3!',
            'description' => 'Третье тестовое действие контроллера TestController',
            'data' => [
                'framework' => 'MVC',
                'language' => 'PHP',
                'version' => '8.0+',
                'features' => ['Роутинг', 'Контроллеры', 'Представления', 'Модели']
            ]
        ]);
    }
}
