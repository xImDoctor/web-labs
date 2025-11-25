<?php
/**
 * Page - Модель для работы со страницами
 * 
 * Задания VI и VII
 * Наследует от Core\Model методы findOne() и findMany()
 * 
 * Структура таблицы pages:
 * - id (INT) - уникальный идентификатор
 * - title (VARCHAR) - заголовок страницы
 * - text (TEXT) - содержимое страницы
 * 
 * @package Project\Models
 */

namespace Project\Models;

use Core\Model;

class Page extends Model
{
    /**
     * Получить страницу по ID
     * 
     * Использует метод findOne() из базового класса Model
     * 
     * @param int $id ID страницы
     * @return array|null Ассоциативный массив с данными страницы или null
     *
     */
    public function getById($id)
    {
        // используем параметризованный запрос для безопасности
        // Метод findOne() автоматически обрабатывает результат и возвращает массив
        return $this->findOne("SELECT * FROM pages WHERE id=$id");
    }
    
    /**
     * Получить страницы в диапазоне ID

     * Использует метод findMany() из базового класса Model
     * 
     * @param int $from Начальный ID (включительно)
     * @param int $to Конечный ID (включительно)
     * @return array Массив страниц
     * 
     */
    public function getByRange($from, $to)
    {
        // Метод findMany() возвращает массив всех найденных записей
        return $this->findMany("SELECT * FROM pages WHERE id>=$from AND id<=$to");
    }
    
    /**
     * Получить все страницы (только id и title)
     * Возвращает список страниц для отображения навигации
     * 
     * @return array Массив страниц с полями id и title
     */
    public function getAll()
    {
        // Выбираем только id и title для списка
        return $this->findMany("SELECT id, title FROM pages ORDER BY id");
    }
    

     // Доп. методы
    /**
     * Получить полную информацию о всех страницах
     * 
     * @return array Массив всех страниц со всеми полями
     */
    public function getAllFull()
    {
        return $this->findMany("SELECT * FROM pages ORDER BY id");
    }
    
    /**
     * Поиск страниц по заголовку
     * 
     * @param string $search Поисковый запрос
     * @return array Массив найденных страниц
     */
    public function searchByTitle($search)
    {
        // Используем LIKE для поиска
        $search = '%' . $search . '%';
        return $this->findMany("SELECT * FROM pages WHERE title LIKE '$search'");
    }
    
    /**
     * Получить количество страниц
     * 
     * @return int Количество страниц в БД
     */
    public function getCount()
    {
        $result = $this->findOne("SELECT COUNT(*) as count FROM pages");
        return $result ? (int)$result['count'] : 0;
    }
}
