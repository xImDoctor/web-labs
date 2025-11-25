<?php
/**
 * PageController - Контроллер для работы со страницами
 * 
 * Используется в заданиях:
 * - IV.3: Работа с массивом страниц и title
 * - VI.2-3: Демонстрация работы с моделью Page
 * - VII.1-7: Полная реализация MVC с базой данных
 * 
 * @package Project\Controllers
 */

namespace Project\Controllers;

use Core\Controller;
use Project\Models\Page;

class PageController extends Controller
{
    /**
     * Массив страниц для задания IV.3
     * Используется для демонстрации работы с title
     * 
     * @var array
     */
    private $pages;
    
    /**
     * Конструктор
     * Инициализирует массив страниц для задания IV.3
     */
    public function __construct()
    {
        // Массив страниц из задания IV.3
        $this->pages = [
            1 => ['title'=>'страница 1', 'text'=>'текст страницы 1'],
            2 => ['title'=>'страница 2', 'text'=>'текст страницы 2'],
            3 => ['title'=>'страница 3', 'text'=>'текст страницы 3'],
        ];
    }
    

     // Методы для работы с массивом
    
    /**
     * Действие showFromArray - показывает страницу из массива
     * Задание IV.3
     * Доступно по адресу: /page/array/:id/
     * 
     * Демонстрирует, как title страницы берется из данных
     * 
     * @param array $params Параметры из URL
     */
    public function showFromArray($params)
    {
        $id = (int)$params['id'];
        
        // Проверяем существование страницы
        if (!isset($this->pages[$id])) {
            $this->title = 'Страница не найдена';
            return $this->render('page/show_array', [
                'error' => 'Страница с ID=' . $id . ' не найдена',
                'page' => null
            ]);
        }
        
        $page = $this->pages[$id];
        
        // title берется из данных страницы
        $this->title = $page['title'];
        
        return $this->render('page/show_array', [
            'page' => $page,
            'h1' => $this->title,
            'error' => null
        ]);
    }
    
    /**
     * Методы для работы с базой данных
     * Задания VI и VII
     */
    
    /**
     * Действие test - тестирует работу модели Page
     * Задание VI.2
     * Доступно по адресу: /page/test/
     * 
     * Демонстрирует использование методов getById() и getByRange()
     */
    public function test()
    {
        $this->title = 'Тестирование модели Page';
        
        $page = new Page; // Создаем объект модели
        
        // Получаем запись с id=3
        $data1 = $page->getById(3);
        
        // Получаем запись с id=5 (если есть)
        $data2 = $page->getById(5);
        
        // Получаем записи с id от 2 до 5
        $data3 = $page->getByRange(2, 5);
        
        return $this->render('page/test', [
            'data1' => $data1,
            'data2' => $data2,
            'data3' => $data3
        ]);
    }
    
    /**
     * Действие one - показывает одну страницу из БД
     * Задание VII.5
     * Доступно по адресу: /page/:id/
     * 
     * Реализация MVC: роут → контроллер → модель → представление
     * 
     * @param array $params Параметры из URL
     */
    public function one($params)
    {
        $id = (int)$params['id'];
        
        // Получаем страницу из БД через модель
        $page = (new Page)->getById($id);
        
        // Проверяем, найдена ли страница
        if (!$page) {
            $this->title = 'Страница не найдена';
            return $this->render('page/one', [
                'error' => 'Страница с ID=' . $id . ' не найдена в базе данных',
                'text' => null,
                'h1' => $this->title
            ]);
        }
        
        // ВАЖНО: title страницы берется из БД (задание VII.5)
        $this->title = $page['title'];
        
        return $this->render('page/one', [
            'text' => $page['text'],
            'h1' => $this->title,
            'error' => null
        ]);
    }
    
    /**
     * Действие all - показывает список всех страниц из БД
     * Задание VII.5
     * Доступно по адресу: /pages/
     * 
     * Выводит список страниц с ссылками на каждую
     */
    public function all()
    {
        $this->title = 'Список всех страниц';
        
        // Получаем все страницы из БД через модель
        $pages = (new Page)->getAll();
        
        return $this->render('page/all', [
            'pages' => $pages,
            'h1' => $this->title,
            'total' => count($pages)
        ]);
    }
}
