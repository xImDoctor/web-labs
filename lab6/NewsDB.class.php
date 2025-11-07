<?php
declare(strict_types=1);

require_once 'INewsDB.class.php';

/**
 * Класс NewsDB
 * Реализует интерфейс INewsDB для работы с новостной лентой
 * Использует PDO для работы с SQLite базой данных (ранее - SQLite3)
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
     * Экземпляр класса PDO
     * @var PDO
     */
    private $_db;
    
    /**
     * Массив категорий для итератора
     * @var array
     */
    private $items = [];
    
    /**
     * Геттер для свойства $_db (для доступа из классов-наследников)
     * @return PDO
     */
    protected function getDb(): PDO {
        return $this->_db;
    }
    
    /**
     * Конструктор класса
     * Выполняет подключение к базе данных SQLite через PDO
     * Если базы данных не существует или её размер равен 0, создает её и таблицы
     */
    public function __construct() {
        // Проверка существования и размера файла БД
        $isNew = !file_exists(self::DB_NAME) || filesize(self::DB_NAME) == 0;
        
        try {
            // Подключение к базе данных через PDO
            $this->_db = new PDO('sqlite:' . self::DB_NAME);
            
            // Установка режима обработки ошибок
            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Установка времени ожидания
            $this->_db->exec('PRAGMA busy_timeout = 5000');
            
            if ($isNew) {
                // Начало транзакции
                $this->_db->beginTransaction();
                
                try {
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
                        id INTEGER PRIMARY KEY,
                        name TEXT
                    )";
                    $this->_db->exec($sql);
                    
                    // Заполнение таблицы category
                    $sql = "INSERT INTO category (id, name) VALUES (1, 'Политика')";
                    $this->_db->exec($sql);
                    
                    $sql = "INSERT INTO category (id, name) VALUES (2, 'Культура')";
                    $this->_db->exec($sql);
                    
                    $sql = "INSERT INTO category (id, name) VALUES (3, 'Спорт')";
                    $this->_db->exec($sql);
                    
                    // Фиксация транзакции
                    $this->_db->commit();
                    
                } catch (PDOException $e) {
                    // Откат транзакции в случае ошибки
                    $this->_db->rollBack();
                    
                    // Удаление файла с ошибкой
                    if (file_exists(self::DB_NAME)) {
                        unlink(self::DB_NAME);
                    }
                    
                    throw new Exception("Невозможно создать базу данных: " . $e->getMessage());
                }
            }
            
            // Загрузка категорий для итератора
            $this->getCategories();
            
        } catch (PDOException $e) {
            throw new Exception("Ошибка подключения к базе данных: " . $e->getMessage());
        }
    }
    
    /**
     * Деструктор класса
     * Закрывает соединение с базой данных
     */
    public function __destruct() {
        $this->_db = null;
    }
    
    /**
     * Получение категорий из базы данных
     * Заполняет массив items для работы итератора
     */
    private function getCategories(): void {
        try {
            $sql = "SELECT id, name FROM category";
            $result = $this->_db->query($sql);
            
            $this->items = [];
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $this->items[$row['id']] = $row['name'];
            }
            
        } catch (PDOException $e) {
            $this->items = []; // В случае ошибки массив остается пустым
        }
    }
    
    /**
     * Реализация метода интерфейса IteratorAggregate
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator {
        return new ArrayIterator($this->items);
    }


    
    /**
     * Сохранение новости в базу данных
     *
     * @param string $title Заголовок новости
     * @param int $category ID категории
     * @param string $description Текст новости
     * @param string $source Источник новости
     * @return bool True в случае успеха, false в случае ошибки
     */
    public function saveNews($title, $category, $description, $source) {
        try {
            $dt = time();
            
            // Экранирование данных с помощью quote
            $title = $this->_db->quote($title);
            $description = $this->_db->quote($description);
            $source = $this->_db->quote($source);
            
            $sql = "INSERT INTO msgs (title, category, description, source, datetime) 
                    VALUES ($title, $category, $description, $source, $dt)";
            
            $result = $this->_db->exec($sql);
            
            // После успешного добавления - обновляем RSS
            if ($result !== false) {
                $this->createRss();
                return true;
            }
            
            return false;
            
        } catch (PDOException $e) {
            error_log("Ошибка сохранения новости: " . $e->getMessage());
            return false;
        }
    }
    

    /**
     * Получение всех новостей из базы данных
     * 
     * @return PDOStatement|bool Результат выборки или false в случае ошибки
     */
    public function getNews() {
        try {
            $sql = "SELECT msgs.id as id, title, category.name as category, description, source, datetime
                    FROM msgs, category
                    WHERE category.id = msgs.category
                    ORDER BY msgs.id DESC";
            
            return $this->_db->query($sql);
            
        } catch (PDOException $e) {
            error_log("Ошибка получения новостей: " . $e->getMessage());
            return false;
        }
    }
    

    /**
     * Удаление новости из базы данных
     *
     * @param int $id ID удаляемой новости
     * @return bool True в случае успеха, false в случае ошибки
     */
    public function deleteNews($id) {
        try {
            $id = (int)$id;
            $sql = "DELETE FROM msgs WHERE id = $id";
            $result = $this->_db->exec($sql);
            
            return $result !== false;
            
        } catch (PDOException $e) {
            error_log("Ошибка удаления новости: " . $e->getMessage());
            return false;
        }
    }
    
    
    /**
     * Создание RSS-документа
     * Формирует RSS-файл на основе новостей из базы данных
     */
    public function createRss(): void {
        try {
            // Создание объекта DOMDocument
            $dom = new DOMDocument('1.0', 'utf-8');
            $dom->formatOutput = true;
            $dom->preserveWhiteSpace = false;
            
            // Создание корневого элемента rss
            $rss = $dom->createElement('rss');
            $rss = $dom->appendChild($rss);
            
            // Создание атрибута version
            $version = $dom->createAttribute('version');
            $version->value = '2.0';
            $rss->appendChild($version);
            
            // Создание элемента channel
            $channel = $dom->createElement('channel');
            $channel = $rss->appendChild($channel);
            
            // Создание элемента title
            $title = $dom->createElement('title', self::RSS_TITLE);
            $channel->appendChild($title);
            
            // Создание элемента link
            $link = $dom->createElement('link', self::RSS_LINK);
            $channel->appendChild($link);
            
            // Получение данных из базы
            $result = $this->getNews();
            
            if ($result !== false) {
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    // Создание элемента item для каждой новости
                    $item = $dom->createElement('item');
                    
                    // Создание элемента title новости
                    $itemTitle = $dom->createElement('title');
                    $itemTitle->appendChild($dom->createTextNode($row['title']));
                    $item->appendChild($itemTitle);
                    
                    // Создание элемента link
                    $itemLink = $dom->createElement('link');
                    $itemLink->appendChild($dom->createTextNode(self::RSS_LINK . '?id=' . $row['id']));
                    $item->appendChild($itemLink);
                    
                    // Создание элемента description с CDATA
                    $itemDescription = $dom->createElement('description');
                    $cdata = $dom->createCDATASection($row['description']);
                    $itemDescription->appendChild($cdata);
                    $item->appendChild($itemDescription);
                    
                    // Создание элемента pubDate
                    $pubDate = $dom->createElement('pubDate');
                    $pubDate->appendChild($dom->createTextNode(date('r', $row['datetime'])));
                    $item->appendChild($pubDate);
                    
                    // Создание элемента category
                    $itemCategory = $dom->createElement('category');
                    $itemCategory->appendChild($dom->createTextNode($row['category']));
                    $item->appendChild($itemCategory);
                    
                    // Добавление item к channel
                    $channel->appendChild($item);
                }
            }
            

            // Сохранение RSS-файла
            $dom->save(self::RSS_NAME);
            
        } catch (Exception $e) {
            error_log("Ошибка создания RSS: " . $e->getMessage());
        }
    }
}
