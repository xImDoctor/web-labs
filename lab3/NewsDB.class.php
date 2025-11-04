<?php
declare(strict_types=1);

require_once 'INewsDB.class.php';

/**
 * Класс NewsDB
 * Реализует интерфейс INewsDB для работы с новостной лентой
 * Использует SQLite3 для хранения данных
 */
class NewsDB implements INewsDB {
    /**
     * Имя файла базы данных
     */
    const DB_NAME = 'news.db';
    
    /**
     * Экземпляр класса SQLite3
     * @var SQLite3
     */
    private $_db;
    
    /**
     * Геттер для свойства $_db (для доступа из классов-наследников)
     * @return SQLite3
     */
    protected function getDb(): SQLite3 {
        return $this->_db;
    }
    
    /**
     * Конструктор класса
     * Выполняет подключение к базе данных SQLite
     * Если базы данных не существует, создает её и таблицы
     */
    public function __construct() {
        $isNew = !file_exists(self::DB_NAME);
        
        // Подключение к базе данных
        $this->_db = new SQLite3(self::DB_NAME);
        $this->_db->busyTimeout(5000);
        
        if ($isNew) {
            // Создание таблицы msgs
            $sql = "CREATE TABLE msgs(
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT,
                category INTEGER,
                description TEXT,
                source TEXT,
                datetime INTEGER
            )";
            $this->_db->exec($sql);
            
            // Создание таблицы category
            $sql = "CREATE TABLE category(
                id INTEGER,
                name TEXT
            )";
            $this->_db->exec($sql);
            

            // Заполнение таблицы category
            $sql = "INSERT INTO category(id, name)
                    SELECT 1 as id, 'Политика' as name
                    UNION SELECT 2 as id, 'Культура' as name
                    UNION SELECT 3 as id, 'Спорт' as name";
            $this->_db->exec($sql);
        }
    }
    

    /**
     * Деструктор класса
     * Закрывает соединение с базой данных
     */
    public function __destruct() {
        unset($this->_db);
    }
    

    /**
     * Добавление новой записи в новостную ленту
     * 
     * @param string $title - заголовок новости
     * @param string $category - категория новости
     * @param string $description - текст новости
     * @param string $source - источник новости
     * 
     * @return boolean - результат успех/ошибка
     */
    function saveNews($title, $category, $description, $source) {
        $dt = time();
        
        // Подготовка запроса для безопасности
        $sql = "INSERT INTO msgs (title, category, description, source, datetime) 
                VALUES (:title, :category, :description, :source, :datetime)";
        
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':title', $title, SQLITE3_TEXT);
        $stmt->bindValue(':category', $category, SQLITE3_INTEGER);
        $stmt->bindValue(':description', $description, SQLITE3_TEXT);
        $stmt->bindValue(':source', $source, SQLITE3_TEXT);
        $stmt->bindValue(':datetime', $dt, SQLITE3_INTEGER);
        
        $result = $stmt->execute();
        
        if ($result) {
            $stmt->close();
            return true;
        }
        
        return false;
    }
    

    /**
     * Выборка всех записей из новостной ленты
     * 
     * @return array - результат выборки в виде массива
     */
    function getNews() {
        $sql = "SELECT msgs.id as id, title, category.name as category, 
                       description, source, datetime 
                FROM msgs, category 
                WHERE category.id = msgs.category 
                ORDER BY msgs.id DESC";
        
        $result = $this->_db->query($sql);
        
        if (!$result)
            return []; // вместо false
        
        
        $items = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC))
            $items[] = $row;
        
        return $items;
    }
    
    /**
     * Удаление записи из новостной ленты
     * 
     * @param integer $id - идентификатор удаляемой записи
     * 
     * @return boolean - результат успех/ошибка
     */
    function deleteNews($id) {
        $sql = "DELETE FROM msgs WHERE id = :id";
        
        $stmt = $this->_db->prepare($sql);
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        
        $result = $stmt->execute();
        
        if ($result) {
            $stmt->close();
            return true;
        }
        
        return false;
    }
}
