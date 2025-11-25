<?php
/**
 * Product - Модель для работы с продуктами
 * 
 * Задание VII.8: Работа с таблицей products в базе данных
 * Наследует от Core\Model методы findOne() и findMany()
 * 
 * Структура таблицы products:
 * - id (INT) - уникальный идентификатор
 * - name (VARCHAR) - название продукта
 * - price (DECIMAL) - цена
 * - quantity (INT) - количество
 * - description (TEXT) - описание
 * 
 * @package Project\Models
 */

namespace Project\Models;

use Core\Model;

class Product extends Model
{
    /**
     * Получить продукт по ID
     * Использует метод findOne() из базового класса Model
     * 
     * @param int $id ID продукта
     * @return array|null Ассоциативный массив с данными продукта или null
     *
     */
    public function getById($id)
    {
        return $this->findOne("SELECT * FROM products WHERE id=$id");
    }
    
    /**
     * Получить все продукты
     * Использует метод findMany() из базового класса Model
     * 
     * @return array Массив всех продуктов
     */
    public function getAll()
    {
        return $this->findMany("SELECT * FROM products ORDER BY id");
    }
    

     // Доп методы
    /**
     * Получить продукты в определенном ценовом диапазоне
     * 
     * @param float $minPrice Минимальная цена
     * @param float $maxPrice Максимальная цена
     * @return array Массив продуктов в диапазоне цен
     */
    public function getByPriceRange($minPrice, $maxPrice)
    {
        return $this->findMany(
            "SELECT * FROM products 
             WHERE price >= $minPrice AND price <= $maxPrice 
             ORDER BY price"
        );
    }
    
    /**
     * Получить продукты с количеством больше указанного
     * 
     * @param int $minQuantity Минимальное количество
     * @return array Массив продуктов
     */
    public function getInStock($minQuantity = 1)
    {
        return $this->findMany(
            "SELECT * FROM products 
             WHERE quantity >= $minQuantity 
             ORDER BY quantity DESC"
        );
    }
    
    /**
     * Получить продукты, которых нет в наличии
     * 
     * @return array Массив продуктов с нулевым количеством
     */
    public function getOutOfStock()
    {
        return $this->findMany("SELECT * FROM products WHERE quantity = 0");
    }
    
    /**
     * Поиск продуктов по названию
     * 
     * @param string $search Поисковый запрос
     * @return array Массив найденных продуктов
     */
    public function searchByName($search)
    {
        $search = '%' . $search . '%';
        return $this->findMany(
            "SELECT * FROM products 
             WHERE name LIKE '$search' 
             OR description LIKE '$search'
             ORDER BY name"
        );
    }
    
    /**
     * Получить количество продуктов в каталоге
     * 
     * @return int Количество продуктов
     */
    public function getCount()
    {
        $result = $this->findOne("SELECT COUNT(*) as count FROM products");
        return $result ? (int)$result['count'] : 0;
    }
    
    /**
     * Получить общую стоимость всех продуктов на складе
     * 
     * @return float Общая стоимость
     */
    public function getTotalValue()
    {
        $result = $this->findOne(
            "SELECT SUM(price * quantity) as total FROM products"
        );
        return $result ? (float)$result['total'] : 0.0;
    }
    
    /**
     * Получить самые дорогие продукты
     * 
     * @param int $limit Количество продуктов
     * @return array Массив самых дорогих продуктов
     */
    public function getMostExpensive($limit = 5)
    {
        return $this->findMany(
            "SELECT * FROM products 
             ORDER BY price DESC 
             LIMIT $limit"
        );
    }
    
    /**
     * Получить самые дешевые продукты
     * 
     * @param int $limit Количество продуктов
     * @return array Массив самых дешевых продуктов
     */
    public function getCheapest($limit = 5)
    {
        return $this->findMany(
            "SELECT * FROM products 
             ORDER BY price ASC 
             LIMIT $limit"
        );
    }
}
