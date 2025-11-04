<?php
declare(strict_types=1);

require_once 'INewsDB.class.php';

/**
 * Класс NewsDB
 * Реализует интерфейс INewsDB для работы с новостной лентой
 * Реализует интерфейс IteratorAggregate для итерации по категориям
 * Использует SQLite3 для хранения данных
 * Поддерживает генерацию RSS-ленты через DOM API
 */
class NewsDB implements INewsDB, IteratorAggregate {
    /**
     * Имя файла базы данных
     */
    const DB_NAME = 'news.db';
    
    /**
     * Имя RSS файла
     */
    const RSS_NAME = 'rss.xml';
    
    /**
     * Заголовок RSS ленты
     */
    const RSS_TITLE = 'Последние новости';
    
    /**
     * Ссылка на новостную ленту
     */
    const RSS_LINK = 'http://f1172321.xsph.ru/lab5/news.php';
    
    /**
     * Экземпляр класса SQLite3
     * @var SQLite3
     */
    private $_db;
    
    /**
     * Массив категорий для итератора
     * @var array
     */
    private array $items = [];
    
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
        
        // Загрузка категорий для итератора
        $this->getCategories();
    }
    
    /**
     * Деструктор класса
     * Закрывает соединение с базой данных
     */
    public function __destruct() {
        unset($this->_db);
    }
    
    /**
     * Загрузка категорий из базы данных
     * Заполняет массив items для итератора
     * 
     * @return void
     */
    private function getCategories(): void {
        $sql = "SELECT id, name FROM category ORDER BY id";
        $result = $this->_db->query($sql);
        
        if ($result) {
            $this->items = [];
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                // Ключ - id категории, значение - название категории
                $this->items[$row['id']] = $row['name'];
            }
        }
    }
    
    /**
     * Реализация метода getIterator() интерфейса IteratorAggregate
     * Возвращает итератор для обхода категорий
     * 
     * @return ArrayIterator Итератор для массива категорий
     */
    public function getIterator(): ArrayIterator {
        return new ArrayIterator($this->items);
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
            // Создание/обновление RSS после добавления новости
            $this->createRss();
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
        
        if (!$result) {
            return false;
        }
        
        $items = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $items[] = $row;
        }
        
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
            // Обновление RSS после удаления новости
            $this->createRss();
            return true;
        }
        
        return false;
    }
    
    /**
     * Создание RSS-ленты с помощью DOM
     * Формирует XML документ с новостями и сохраняет в файл
     * 
     * @return void
     */
    public function createRss(): void {
        // Создание объекта DOMDocument
        $dom = new DOMDocument('1.0', 'utf-8');
        
        // Настройки форматирования
        $dom->formatOutput = true;
        $dom->preserveWhiteSpace = false;
        
        // Создание корневого элемента rss
        $rss = $dom->createElement('rss');
        $rss = $dom->appendChild($rss);
        
        // Создание атрибута version для rss
        $version = $dom->createAttribute('version');
        $version->value = '2.0';
        $rss->appendChild($version);
        
        // Создание элемента channel
        $channel = $dom->createElement('channel');
        $channel = $rss->appendChild($channel);
        
        // Создание элемента title для канала
        $title = $dom->createElement('title', self::RSS_TITLE);
        $channel->appendChild($title);
        
        // Создание элемента link для канала
        $link = $dom->createElement('link', self::RSS_LINK);
        $channel->appendChild($link);
        
        // Получение данных из базы
        $newsItems = $this->getNews();
        
        if ($newsItems && is_array($newsItems)) {
            // Обход всех новостей и создание элементов item
            foreach ($newsItems as $news) {
                // Создание элемента item
                $item = $dom->createElement('item');
                
                // title новости
                $itemTitle = $dom->createElement('title', htmlspecialchars($news['title']));
                $item->appendChild($itemTitle);
                
                // link на новость (формируем ссылку с ID)
                $itemLink = $dom->createElement('link');
                $itemLinkText = $dom->createTextNode(self::RSS_LINK . '?id=' . $news['id']);
                $itemLink->appendChild($itemLinkText);
                $item->appendChild($itemLink);
                
                // description с CDATA секцией
                $itemDesc = $dom->createElement('description');
                $cdata = $dom->createCDATASection($news['description']);
                $itemDesc->appendChild($cdata);
                $item->appendChild($itemDesc);
                
                // pubDate - дата публикации в формате RSS
                $pubDate = $dom->createElement('pubDate');
                $pubDateText = $dom->createTextNode(date(DATE_RSS, $news['datetime']));
                $pubDate->appendChild($pubDateText);
                $item->appendChild($pubDate);
                
                // category
                $itemCategory = $dom->createElement('category', htmlspecialchars($news['category']));
                $item->appendChild($itemCategory);
                
                // Привязка item к channel
                $channel->appendChild($item);
            }
        }
        
        // Сохранение файла
        $dom->save(self::RSS_NAME);
    }
}
?>