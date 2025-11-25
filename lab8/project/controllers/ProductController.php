<?php
/**
 * ProductController - Контроллер для работы с продуктами
 * 
 * Задания III.1-4: Контроллер с массивом продуктов и представлениями
 * Демонстрирует работу с представлениями, HTML версткой и табличными данными
 * 
 * Используется как в заданиях III (с массивом), так и в VII.8 (с БД через модель)
 * 
 * @package Project\Controllers
 */

namespace Project\Controllers;

use Core\Controller;
use Project\Models\Product; // Для задания VII.8

class ProductController extends Controller
{
    /**
     * Массив продуктов
     * Задается в конструкторе
     * 
     * @var array
     */
    private $products;
    
    /**
     * Конструктор
     * Инициализирует массив продуктов
     */
    public function __construct()
    {
        parent::__construct();
        
        // Массив продуктов
        $this->products = [
            1 => [
                'name' => 'product1',
                'price' => 100,
                'quantity' => 5,
                'category' => 'category1',
            ],
            2 => [
                'name' => 'product2',
                'price' => 200,
                'quantity' => 6,
                'category' => 'category2',
            ],
            3 => [
                'name' => 'product3',
                'price' => 300,
                'quantity' => 7,
                'category' => 'category2',
            ],
            4 => [
                'name' => 'product4',
                'price' => 400,
                'quantity' => 8,
                'category' => 'category3',
            ],
            5 => [
                'name' => 'product5',
                'price' => 500,
                'quantity' => 9,
                'category' => 'category3',
            ],
        ];
    }
    
    /**
     * Действие show - показывает информацию об одном продукте
     * Задания III.2-3
     * Доступно по адресу: /product/:n/
     * 
     * Примеры:
     * - /product/1/ → Продукт product1
     * - /product/3/ → Продукт product3
     * 
     * Выводит оформленную страницу с информацией о продукте
     * 
     * @param array $params Параметры из URL
     */
    public function show($params)
    {
        $n = (int)$params['n'];
        
        // Проверяем существование продукта
        if (!isset($this->products[$n])) {
            $this->title = 'Продукт не найден';
            return $this->render('product/show', [
                'error' => 'Продукт с номером ' . $n . ' не найден',
                'product' => null
            ]);
        }
        
        $product = $this->products[$n];
        
        // Вычисляем стоимость (цена * количество)
        $cost = $product['price'] * $product['quantity'];
        
        $this->title = 'Продукт "' . $product['name'] . '"';
        
        return $this->render('product/show', [
            'id' => $n,
            'product' => $product,
            'cost' => $cost,
            'error' => null
        ]);
    }
    
    /**
     * Действие all - показывает список всех продуктов в виде таблицы
     * Задание III.4
     * Доступно по адресу: /products/all/
     * 
     * Выводит HTML таблицу с информацией о всех продуктах
     */
    public function all()
    {
        $this->title = 'Список всех продуктов';
        
        // Вычисляем стоимость для каждого продукта
        $productsWithCost = [];
        foreach ($this->products as $id => $product) {
            $productsWithCost[$id] = $product;
            $productsWithCost[$id]['cost'] = $product['price'] * $product['quantity'];
        }
        
        // Вычисляем общую стоимость
        $totalCost = array_sum(array_column($productsWithCost, 'cost'));
        
        return $this->render('product/all', [
            'products' => $productsWithCost,
            'total' => count($productsWithCost),
            'totalCost' => $totalCost
        ]);
    }
    
    /**
     * Методы для работы с базой данных
     * Задание VII.8
     */
    
    /**
     * Действие showFromDb - показывает продукт из базы данных
     * Задание VII.8
     * Доступно по адресу: /product/db/:id/
     * 
     * Аналог show(), но работает с БД через модель Product
     * 
     * @param array $params Параметры из URL
     */
    public function showFromDb($params)
    {
        $id = (int)$params['id'];
        
        // Получаем продукт из БД через модель
        $product = (new Product)->getById($id);
        
        if (!$product) {
            $this->title = 'Продукт не найден';
            return $this->render('product/show_db', [
                'error' => 'Продукт с ID=' . $id . ' не найден в базе данных',
                'product' => null
            ]);
        }
        
        // Вычисляем стоимость
        $cost = $product['price'] * $product['quantity'];
        
        $this->title = 'Продукт "' . $product['name'] . '"';
        
        return $this->render('product/show_db', [
            'product' => $product,
            'cost' => $cost,
            'error' => null
        ]);
    }
    
    /**
     * Действие allFromDb - показывает все продукты из базы данных
     * Задание VII.8
     * Доступно по адресу: /products/db/
     * 
     * Аналог all(), но работает с БД через модель Product
     */
    public function allFromDb()
    {
        $this->title = 'Каталог продуктов (из БД)';
        
        // Получаем все продукты из БД через модель
        $products = (new Product)->getAll();
        
        // Вычисляем стоимость для каждого
        $totalCost = 0;
        foreach ($products as &$product) {
            $product['cost'] = $product['price'] * $product['quantity'];
            $totalCost += $product['cost'];
        }
        
        return $this->render('product/all_db', [
            'products' => $products,
            'total' => count($products),
            'totalCost' => $totalCost
        ]);
    }
}
